<?php

class Student extends AppModel {

	public $validate = [
		'name' => [
			'rule' => 'isUnique',
			'message' => '学生名が既に登録されています',
		],
		'student_number' => [
			'rule' => 'isUnique',
			'message' => '学生番号は既に登録されています',
		],
		'email' => [
			'rule' => 'isUnique',
			'message' => '学生のメールアドレスが既に登録されています',
		],
	];
}