<?php

class StudentSubject extends AppModel {

	public $belongsTo = 'Student';
	// student_subject中間テーブル
	public function save_student_subject($student_id = null, $major_id = null, $status = null)
	{
		// Major Modelを呼び出す
		$Major = ClassRegistry::init('Major');
		// majorを取得し
		$major = $Major->find('first', [
			'conditions' => [
				'id' => $major_id,
				'school_id' => AuthComponent::user('school_id'),
			],
		]);
		if (empty($major))
		{
			return true;
		}

		if (empty($major['Subject']))
		{
			return true;
		}
		// majorにjoinされているsubjectたちのidを取得
		$subject_id_list = [];
		foreach ($major['Subject'] as $value)
		{
			$subject_id_list[] = $value['id'];
		}
		
		$data =[];
		foreach ($subject_id_list as $value) {
			$data[] = [
				'student_id' => $student_id,
				'subject_id' => $value,
				'school_id' => AuthComponent::user('school_id'),
			];
		}
		// 編集の場合
		if ($status == 28)
		{
			$this->deleteAll([
				'student_id' => $student_id,
			]);
		}

		if ($this->saveAll($data) == false)
		{
			return false;
		}
		return true;
	}

	// 授業に参加している学生を取得
	public function get_attend_student_list ($class_id = null)
	{
		$ClassStudent = ClassRegistry::init('ClassStudent');
		// 授業を受ける学生リスト
		$get_student_id = $ClassStudent->find('all',[
			'conditions' => [
				'class_room_id' => $class_id,
				'school_id' => AuthComponent::user('school_id'),
			],
			'fields' => ['student_id'],
		]);
		$student_ids = [];
		foreach ($get_student_id as $value) {
			$student_ids[] = $value['ClassStudent']['student_id'];
		}
		// Student
		$Student = ClassRegistry::init('Student');
		$get_student = $Student->find('all',[
			'conditions' => [
				'id' => $student_ids,
			],
		]);
		//　学生を表示するため配列データ
		$student_name_list = [];
		// Major Modelを呼び出す
		$Major = ClassRegistry::init('Major');
		//　学生を表示するため配列データ
		$student_name_list = [];
		foreach ($get_student as $student)
		{
			$student_name_list[] = [
				'id' => $student['Student']['id'],
				'name' => $student['Student']['name'],
				'img' => $student['Student']['image'],
				// ここはちょっと気持ち悪いなぁ
				'major' => $Major->find('first',[
					'conditions' => [
						'id' => $student['Student']['major_id'],
						'school_id' => AuthComponent::user('school_id'),
					],
					'fields' => ['name'],
					'recursive' => -1,
				]),
			];
		}
		return $student_name_list;
	}

	// 学生を削除するとき中間テーブルも削除
	// 1.studentsubject delete where student_id = $id
	public function delete_student($id)
	{
		if ($this->deleteAll(['student_id' => $id]) == false)
		{
			return false;
		}
		return true;
	}
}