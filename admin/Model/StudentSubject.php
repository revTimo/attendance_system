<?php

class StudentSubject extends AppModel {

	public $belongsTo = 'Student';
	
	// student_subject中間テーブル
	public function save_student_subject($student_id = null, $major_id = null)
	{
		// Major Modelを呼び出す
		$Major = ClassRegistry::init('Major');
		// majorを取得し
		$major = $Major->find('first', [
			'conditions' => [
				'id' => $major_id,
			],
		]);

		if (empty($major))
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
			];
		}
		if ($this->saveAll($data) == false)
		{
			return false;
		}
		return true;
	}
}