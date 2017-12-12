<?php

class SubjectsController extends AppController {
	public $uses = [
		'Subject',
		'Major',
		'StudentSubject',
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
			//科目があるときだけ
			if (!empty($this->request->data['Subject']['subjects']))
			{
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
				/*
				 *　ここに中間テーブルに保存の処理が入る
				 *　今すぐ【上の】保存したsubject idをもらって
				 *　中間テーブルに学生ＩＤと保存
				 * $subject_id_list = $this->Subject->subject_ids;
				　*/
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
		//複数の削除の場合postになる
		if ($this->request->is('post'))
		{
			//まずは削除する専攻idから関連科目全てを取得
			$multi_delete_data = [];
			foreach ($this->request->data['deletedata'] as $value)
			{
				$multi_delete_data[] = $this->Major->find('first', [
					'conditions' => [
						'id' => $value
					],
					'fields' => ['id']
				]);
			}
			
			//複数の専攻id
			$major_ids = [];
			//複数の科目のid
			$subject_ids = [];
			foreach ($multi_delete_data as $value)
			{
				$major_ids[] = $value['Major']['id'];
				foreach ($value['Subject'] as $sub_value)
				{
					$subjects_ids[] = $sub_value['id'];
				}
			}
			//削除するrecordのidsをセット
			$this->Major->id = $major_ids;
			//専攻だけ登録されている場合
			if (!empty($subjects_ids))
			{
				$this->Subject->id = $subjects_ids;
			}
		}

		//一個ずつで削除
		if ($this->request->is('get'))
		{
			$subject_delete = $this->Major->find('first', [
				'conditions' => [
					'id' => $id,
				],
			]);
			//無理やり存在しないidを入力して、アタック
			if (empty($subject_delete))
			{
				return $this->redirect(['action' => 'index']);
			}
			//削除するrecordのidをセット
			$this->Major->id = $id;
			
			//削除する科目のidまとめ
			$subs_ids = [];
			foreach ($subject_delete['Subject'] as $key => $value) {
				$subs_ids[] = $value['id'];
			}
			//削除するrecordのidをセット
			$this->Subject->id = $subs_ids;

			//他の学校のidできないように
			if ($this->Auth->user('school_id') != $subject_delete['Major']['school_id'])
			{
				$this->Flash->setFlashError('不正アクセス');
				return $this->redirect(['action' => 'index']);
			}
		}

		//POSTもGETも共通、削除処理
		try
		{
			$this->Subject->begin();
			
			//専攻は１つだけなので固定ＩＤを指定して1rowだけを削除
			if ($this->Major->delete() == false)
			{
				$this->Flash->setFlashError('専攻削除失敗しました');
				return $this->redirect(['action' => 'index']);
				$this->Subject->rollback();
			}

			//念のためもしsubjectsが空で入ってきた場合
			if (empty($subs_ids) && empty($subjects_ids))
			{
				$this->Subject->commit();
				$this->Flash->setFlashSuccess('専攻を削除しました');
				return $this->redirect(['action' => 'index']);
			}
			
			//科目は複数なのでidをまとめてdeleteで削除
			if ($this->Subject->delete() == false)
			{
				$this->Flash->setFlashError('科目の削除が失敗');
				return $this->redirect(['action' => 'index']);
				$this->Subject->rollback();
			}

			$this->Subject->commit();
			$this->Flash->setFlashSuccess('専攻と科目を削除しました');
			return $this->redirect(['action' => 'index']);
		}
		catch(Exception $e)
		{
			$this->Subject->rollback();
			$this->Flash->setFlashError('削除できませんでした'.$e);
			return $this->redirect(['action' => 'index']);
		}
	}

	//編集画面の科目を削除
	public function delete_edit ()
	{
		$this->autoRender = FALSE;
		if ($this->request->is('ajax'))
		{
			if (empty($this->request->data['id']))
			{
				return;
			}
			$this->Subject->id = $this->request->data['id'];
			$this->Subject->delete();
			return;
		}
	}
}