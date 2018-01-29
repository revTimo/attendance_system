<?php
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class StudentUser extends AppModel {
	public $validate = [
		'student_number' => [
			'rule' => 'isUnique',
			'message' => '既に登録されています',
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

	//学生アカウント発行メール
	public function student_account_create_mail ($student = null)
	{
		$Email = new CakeEmail();
		$Email->from(['info-attendance@gmail.com' => '出席管理システム']);
		$Email->to($student['email']);
		$Email->subject('学生アカウント発行');
		$info_mail = [
			'target_student' => $student['name'],
			'temp_password' => $student['password'],
			'student_number' => $student['student_number'],
		];
		$Email->template('student_account_mail','default');
		$Email->emailFormat('text');
		$Email->viewVars($info_mail);
		if ( ! $Email->send())
		{
			return false;
		}
	}
}