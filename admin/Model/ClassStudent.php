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
				'school_id' => AuthComponent::user('school_id'),
			];
		}

		// 編集のとき削除しちゃう
		/*if ($status == 'edit')
		{
			$this->deleteAll([
				'class_room_id' => $class_id,
			]);
		}*/

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

	// 学生を削除するとき中間テーブルも削除
	// 2.classstudent delete where student_id => $id
	public function delete_student($id)
	{
		$find_student = $this->find('all', [
			'conditions' => [
				'student_id' => $id,
			],
		]);
		if (!empty($find_student))
		{
			if ($this->deleteAll(['student_id' => $id]) == false)
			{
				return false;
			}
		}
		return true;
	}

}