<?php

class Major extends AppModel {

	//一つの専攻が複数の科目を持つ
	public $hasMany = [
		'Subject' => [
			'className' => 'Subject',
		],
	];
}