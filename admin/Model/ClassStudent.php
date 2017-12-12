<?php

class ClassStudent extends AppModel {
	
	public function save_class_student ($class_id = null, $students_id = null)
	{
		$class_student_id_list = [];
		foreach ($students_id as $student)
		{
			$class_student_id_list[] = [
				'class_room_id' => $class_id,
				'student_id' => $student,
			];
		}

		if ($this->saveAll($class_student_id_list) == false)
		{
			return false;
		}
		return true;
	}

	public function get_attend_students($class_id = null)
	{
		$data = $this->find('list', [
			'conditions' => [
				'school_id' => AuthComponent::user('school_id'),
				'class_room_id' => $class_id,
			],
		]);
		return $data;
	}
}