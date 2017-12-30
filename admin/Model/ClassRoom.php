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

	public function door ($class_id = null)
	{
		$class = $this->find('first', [
			'conditions' => [
				'id' => $class_id,
			],
			'fields' => ['school_id'],
		]);
		if (empty($class))
		{
			return false;
		}
		if ($class['ClassRoom']['school_id'] != AuthComponent::user('school_id'))
		{
			return false;
		}

		return true;
	}

	public function save_class_room ($class_id, $data = null, $status = null)
	{
		$class_room_data = [
			'name' => $data['ClassRoom']['name'],
			'subject_id' => $data['ClassRoom']['subject_id'],
			'school_id' => AuthComponent::user('school_id'),
			'grade' => $data['ClassRoom']['grade'],
			'start_time' => $data['ClassRoom']['start_time'],
			'end_time' => $data['ClassRoom']['end_time'],
			'semester_from' => $data['ClassRoom']['semester_from'],
			'semester_to' => $data['ClassRoom']['semester_to'],
		];

		if ($status == 'edit')
		{
			$this->id = $class_id;
		}
		
		if ($this->save($class_room_data) == false)
		{
			return false;
		}
		return true;
	}
}