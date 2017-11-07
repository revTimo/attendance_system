<?php
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');
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

	public function beforeSave($options = []) {
		if (isset($this->data[$this->alias]['password']))
		{
			$passwordHasher = new BlowfishPasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']);
		}
    	return true;
	}
}