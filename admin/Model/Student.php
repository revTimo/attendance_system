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

		//画像のバリテーションはjsに任せ
		/*'image' => [
			'rule' => [
				'extension',
				['fileSize', '<=', '1MB'],
				['jpeg', 'png', 'jpg'],
			],
			'message' => 'ファイルアップロードできませんでした。画像は 1MB 未満でなければなりません。有効な画像ファイルを指定してください。',
		],*/
	];
}