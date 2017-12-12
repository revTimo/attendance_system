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
}