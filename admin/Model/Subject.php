<?php

class Subject extends AppModel {
	public $subject_ids = [];

	public function afterSave($created, $option = [])
	{
		if($created)
		{
			$this->subject_ids[] = $this->getInsertID();
		}
		return true;
	}

	// 一覧取得
	public function subject_list ()
	{
		$data = $this->find('list', [
			'conditions' => [
				'school_id' => AuthComponent::user('school_id'),
			],
		]);
		return $data;
	}
}