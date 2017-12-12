<?php

class ClassRoom extends AppModel {
	public $validate = [
		'name' => [
			'rule' => 'isUnique',
			'message' => '教室名が既に登録されています',
		],
		'subject_id' => [
			'rule' => 'isUnique',
			'message' => '選択した授業が既に登録されています',
		],
	];
}