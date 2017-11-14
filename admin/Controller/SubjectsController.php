<?php

class SubjectsController extends AppController {
	public $uses = [
		'Subject',
		'Major',
	];
	public function index ()
	{
		$data = $this->Major->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
			'order' => [
				'Major.modified' => 'desc'
			],
		]);
		$this->set('majors_subjects', $data);
	}

	//専攻や科目を入力した後確認画面
	public function confirm_subject ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
		$this->set('major_subjects',$this->request->data);
	}

	//学科登録
	public function add_subject ()
	{
		if ($this->request->is('get'))
		{
			return;
		}

		$major = [
			'name' => $this->request->data['Subject']['major_name'],
			'school_id' => $this->Auth->user('school_id'),
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
				return $this->redirect(['action' => 'index']);
			}
			
			//専攻id　と　科目
			foreach ($this->request->data['Subject']['subjects'] as $key => $value)
			{
				$subjects[] = [
					'major_id' => $this->Major->id,
					'name' => $value,
					'school_id' => $this->Auth->user('school_id'),
				];
			}

			if ($this->Subject->saveAll($subjects) == false)
			{
				$this->Subject->rollback();
				$this->Flash->setFlashError('科目登録失敗');
				return $this->redirect(['action' => 'index']);
			}

			$this->Subject->commit();
		}
		catch (Exception $e)
		{
			$this->Subject->rollback();
			$this->Flash->setFlashError('登録できませんでした。'.$e);
			return $this->redirect(['action' => 'index']);
		}

		//成功
		$this->Flash->setFlashSuccess('登録完了しました');
		return $this->redirect(['action' => 'index']);
	}

	public function edit ($id = null)
	{
		$edit_subject = $this->Major->find('first', [
			'conditions' => [
				'id' => $id,
			],
		]);

		//編集画面に編集する内容を表示できるように
		if ($this->request->is('get'))
		{
			//無理やり存在しないidを入力して、アタック
			if (empty($edit_subject))
			{
				return $this->redirect(['action' => 'index']);
			}
			//他の学校のidも編集できないように
			if ($this->Auth->user('school_id') != $edit_subject['Major']['school_id'])
			{
				$this->Flash->setFlashError('不正アクセス');
				return $this->redirect(['action' => 'index']);
			}
			$this->set('edit_subject', $edit_subject);
		}
		

		//編集する
		if ($this->request->is('post'))
		{
			$major = [
				'name' => $this->request->data['Subject']['major_name'],
				'school_id' => $this->Auth->user('school_id'),
			];
			$subjects = [];
			$new_subjects = [];
			try
			{
				//トランザクション
				$this->Subject->begin();
				//専攻名編集登録
				$this->Major->id = $id;
				if ($this->Major->save($major) == false)
				{
					$this->Subject->rollback();
					$this->Flash->setFlashError('専攻編集失敗');
					return $this->redirect(['action' => 'index']);
				}

				//もとからあったsubjectを編集の場合
				//subject idを代入して、全てupdate
				//もし、これが空でpostされる可能性もあるので
				if (array_key_exists('subjects', $this->request->data['Subject']))
				{
					foreach ($this->request->data['Subject']['subjects'] as $key => $value)
					{
						$subjects[] = [
							'id' => $value['id'],
							'major_id' => $id,
							'name' => $value['name'],
							'school_id' => $this->Auth->user('school_id'),
						];
					}
					if ($this->Subject->saveAll($subjects) == false)
					{
						$this->Subject->rollback();
						$this->Flash->setFlashError('科目の編集失敗');
						return $this->redirect(['action' => 'index']);
					}
				}
				
				//もし編集画面に新しい科目を追加した場合
				if (array_key_exists('new_subjects', $this->request->data['Subject']))
				{
					foreach ($this->request->data['Subject']['new_subjects'] as $key => $value)
					{
						$new_subjects[] = [
							'major_id' => $id,
							'name' => $value,
							'school_id' => $this->Auth->user('school_id'),
						];
					}
					if ($this->Subject->saveAll($new_subjects) == false)
					{
						$this->Subject->rollback();
						$this->Flash->setFlashError('新しい科目登録失敗');
						return $this->redirect(['action' => 'index']);
					}
				}
				$this->Subject->commit();
			}
			catch (Exception $e)
			{
				$this->Subject->rollback();
				$this->Flash->setFlashError('編集できませんでした。'.$e);
				return $this->redirect(['action' => 'index']);
			}

			//全て成功成功
			$this->Flash->setFlashSuccess('編集完了しました');
			return $this->redirect(['action' => 'index']);
		}
	}

	public function delete ($id = null)
	{
		$subject_delete = $this->Major->find('first', [
			'conditions' => [
				'id' => $id,
			],
		]);
		pr($subject_delete);
		exit;
		//無理やり存在しないidを入力して、アタック
		if (empty($subject_delete))
		{
			return $this->redirect(['action' => 'index']);
		}
		//他の学校のidも編集できないように
		if ($this->Auth->user('school_id') != $subject_delete['Major']['school_id'])
		{
			$this->Flash->setFlashError('不正アクセス');
			return $this->redirect(['action' => 'index']);
		}

		try
		{
			$this->Subject->begin();
			$this->Major->id = $id;
			if ($this->Major->deleteAll($subject_delete) == false)
			{
				$this->Flash->setFlashError('削除失敗しました');
				return $this->redirect(['action' => 'index']);
				$this->Subject->rollback();
			}
			$this->Subject->commit();
		}
		catch(Exception $e)
		{
			$this->Subject->rollback();
			$this->Flash->setFlashError('削除できませんでした'.$e);
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->setFlashSuccess('専攻と科目を削除しました');
		return $this->redirect(['action' => 'index']);
	}
}