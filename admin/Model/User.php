<?php
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class User extends AppModel {

	public $validate = [
		'user_name' => [
			'required' => true,
			'allowEmpty' => false,
			'on' => 'create',
			'message' => '入力してください',
		],
		'email' => [
			'rule' => 'isUnique',
			'message' => '登録しようとするメールアドレスが既に登録されています',
		],
		'password' => [
			'rule' => ['minLength','8'],
			'on' => 'create',
			'message' => 'パスワードは最低8文字です',
		],
	];

	//blowfishpassword hash
	public function beforeSave($options = [])
	{
		if (isset($this->data[$this->alias]['password']))
		{
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}

	//メンバー招待メール
	public function member_invite_mail ($member = null)
	{

		$Email = new CakeEmail();
		$Email->from(['info-attendance@gmail.com' => '出席管理システム']);
		$Email->to($member['email']);
		$Email->subject('管理者追加連絡！');
		$info_mail = [
			'target_member' => $member['name'],
			'temp_password' => $member['password'],
			'email' => $member['email'],
			'admin' => AuthComponent::user('name'),
		];
		$Email->template('member_mail','default');
		$Email->emailFormat('text');
		$Email->viewVars($info_mail);
		if ( ! $Email->send())
		{
			return false;
		}
	}
}