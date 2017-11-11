<?php

class SubjectsController extends AppController {
	public $uses = [
		'Subject',
		'Major',
	];
	public function index ()
	{

	}

	public function confirm_subject ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
		$this->set('major_subjects',$this->request->data);
	}

	public function add_subject ()
	{
		if ($this->request->is('get'))
		{
			return;
		}

		$major = [
			'name' => $this->request->data['Subject']['major_name'],
		];
		$subjects = [];
		try
		{
			//トランザクション
			$this->Subject->begin();
			//専攻登録
			if ($this->Major->save($major) == false)
			{
				$this->Subject->rollback();
				$this->Flash->setFlashError('専攻登録失敗');
				return $this->redirect(['action' => 'indexs']);
			}
			
			//専攻id　と　科目
			foreach ($this->request->data['Subject']['subjects'] as $key => $value)
			{
				$subjects[] = [
					'major_id' => $this->Major->id,
					'name' => $value,
				];
			}

			if ($this->Subject->saveAll($subjects) == false)
			{
				$this->Subject->rollback();
				$this->Flash->setFlashError('科目登録失敗');
				return $this->redirect(['action' => 'indexs']);
			}

			$this->Subject->commit();
		}
		catch (Exception $e)
		{
			$this->Subject->rollback();
			$this->Flash->setFlashError('登録できませんでした。'.$e);
			return $this->redirect(['action' => 'indexs']);
		}

		//成功
		$this->Flash->setFlashSuccess('登録完了しました');
		return $this->redirect(['action' => 'index']);
	}
}