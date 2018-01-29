<?php

class Attendance extends AppModel {

	// 学生削除のとき
	public function delete_student ($id)
	{
		$find_student = $this->find('all', [
			'conditions' => [
				'id' => $id,
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