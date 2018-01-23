<?php

class ClassRoomsController extends AppController {

	public $uses = [
		'User',
		'Student',
		'ClassRoom',
		'Major',
		'Subject',
		'StudentSubject',
		'ClassStudent',
	];

	public function class_list ()
	{
		// 教室一覧ページ
		$class = $this->ClassRoom->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		$this->set('class_list', $class);

		// Subject Modelから一覧取得
		$subject_list = $this->Subject->subject_list($this->Auth->user('school_id'));
		$this->set('subject_list', $subject_list);
	}

	public function index ()
	{
		// 科目選択select fieldのため一覧取得
		$all_subject = $this->Subject->find('list',[
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		$this->set('all_subject', $all_subject);
	}

	// 確認画面
	public function confirm ()
	{
		if ($this->request->is('get'))
		{
			return $this->redirect(['action' => 'index']);
		}
		// major nameが前のページのときfind listだったのでidだけが表示にならないように
		$subject = $this->Subject->find('first', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
				'id' => $this->request->data['ClassRoom']['subject_id']
			],
			'fields' => ['name'],
		]);

		// 授業を受ける学生リスト
		$get_student = $this->StudentSubject->find('all',[
			'conditions' => [
				'subject_id' => $this->request->data['ClassRoom']['subject_id'],
				//'school_id' => $this->Auth->user('school_id'),
			],
		]);

		//　学生を表示するため配列データ
		$student_name_list = [];
		foreach ($get_student as $student)
		{
			$student_name_list[] = [
				'id' => $student['Student']['id'],
				'name' => $student['Student']['name'],
				'img' => $student['Student']['image'],
				// ここはちょっと気持ち悪いなぁ
				'major' => $this->Major->find('first',[
					'conditions' => [
						'id' => $student['Student']['major_id'],
						'school_id' => $this->Auth->user('school_id'),
					],
					'fields' => ['name'],
					'recursive' => -1,
				]),
			];
		}

		$this->set('student_list', $student_name_list);
		$this->set('data', $this->request->data['ClassRoom']);
		$this->set('subject_name', $subject['Subject']['name']);

	}

	//クラス登録
	public function add ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
		try
		{
			$this->ClassRoom->begin();
			// まず教室の保存
			$class_room_data = [
				'name' => $this->request->data['ClassRoom']['name'],
				'subject_id' => $this->request->data['ClassRoom']['subject_id'],
				'school_id' => $this->Auth->user('school_id'),
				'grade' => $this->request->data['ClassRoom']['grade'],
				'start_time' => $this->request->data['ClassRoom']['start_time'],
				'end_time' => $this->request->data['ClassRoom']['end_time'],
				'week' => $this->request->data['ClassRoom']['week'],
				'semester_from' => $this->request->data['ClassRoom']['semester_from'],
				'semester_to' => $this->request->data['ClassRoom']['semester_to'],
			];
			if ($this->ClassRoom->save($class_room_data) == false)
			{
				$this->ClassRoom->rollback();
				$this->Flash->setFlashError('教室の登録が失敗しました');
				return $this->redirect(['action' => 'index']);
			}

			// 学生はいない、教室だけを作成のとき
			if (isset($this->request->data['ClassRoom']['students_id']))
			{
				// classroomstudentに教室IDと参加学生ID保存
				if ($this->ClassStudent->save_class_student($this->ClassRoom->id, $this->request->data['ClassRoom']['students_id']) == false)
				{
					$this->ClassRoom->rollback();
					$this->Flash->setFlashError('ClassStudentの登録が失敗しました');
					return $this->redirect(['action' => 'index']);
				}
			}
			$this->ClassRoom->commit();
		}
		catch(Exception $e)
		{
			$this->ClassRoom->rollback();
			$this->Flash->setFlashError('教室の登録が全て失敗');
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->setFlashSuccess('教室の登録完了');
		return $this->redirect(['action' => 'class_list']);
	}

	// 詳細
	public function detail ($class_id = null)
	{
		// 他のIDを編集できないように
		if ($this->ClassRoom->door($class_id) == false)
		{
			$this->Flash->setFlashError('不正なアクセスはできません');
			return $this->redirect(['action' => 'class_list']);
		}
		// retrieve edit data
		$class_data = $this->ClassRoom->find('first', [
			'conditions' => [
				'id' => $class_id,
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		// subject idだけが表示にならないように
		$subject = $this->Subject->find('first', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
				'id' => $class_data['ClassRoom']['subject_id']
			],
			'fields' => ['name'],
		]);

		
		$this->set('data', $class_data['ClassRoom']);
		$this->set('subject_name', $subject['Subject']['name']);
		// 参加学生一覧
		$student_list = $this->StudentSubject->get_attend_student_list($class_id);
		$this->set('student_list', $student_list);

	}

	// クラス編集
	public function edit ($class_id = null)
	{
		if ($this->request->is('get'))
		{
			// 他のIDを編集できないように
			if ($this->ClassRoom->door($class_id) == false)
			{
				$this->Flash->setFlashError('不正なアクセスはできません');
				return $this->redirect(['action' => 'class_list']);
			}
			// retrieve edit data
			$edit_data = $this->ClassRoom->find('first', [
				'conditions' => [
					'id' => $class_id,
					'school_id' => $this->Auth->user('school_id'),
				],
			]);

			// 参加学生一覧
			$student_list = $this->StudentSubject->get_attend_student_list($class_id);
			$this->set('data', $edit_data['ClassRoom']);
			$all_subject = $this->Subject->subject_list();
			$this->set('all_subject', $all_subject);
			$this->set('student_list', $student_list);
		}

		if ($this->request->is('post'))
		{
			try
			{
				$this->ClassRoom->begin();
				// class_rooms
				if ($this->ClassRoom->save_class_room($class_id, $this->request->data, 'edit') == false)
				{
					$this->ClassRoom->rollback();
					$this->Flash->setFlashError('編集できませんでした。(classroom保存失敗)');
					return $this->redirect(['action' => 'class_list']);
				}

				$this->ClassStudent->deleteAll(['class_room_id' => $class_id]);
				// 学生がいないとき無視する
				if (isset($this->request->data['ClassRoom']['students_id']))
				{
					// class_student
					if ($this->ClassStudent->save_class_student($class_id, $this->request->data['ClassRoom']['students_id']) == false)
					{
						$this->ClassRoom->rollback();
						$this->Flash->setFlashError('編集できませんでした。(classroom保存失敗)');
						return $this->redirect(['action' => 'class_list']);
					}
				}

				$this->ClassRoom->commit();
				$this->Flash->setFlashSuccess('編集しました。');
				return $this->redirect(['action' => 'class_list']);
			}
			catch(Exception $e)
			{
				$this->ClassRoom->rollback();
				$this->Flash->setFlashError('編集できませんでした。');
				return $this->redirect(['action' => 'class_list']);
			}
		}
	}

	//クラス削除
	public function delete ($id = null)
	{
		// 一個削除
		if ($this->request->is('get'))
		{
			// まず他のidが削除されないように
			// 今ログインしている、ユーザーのschool_idと削除するデータのschool_id
			$target_class = $this->ClassRoom->find('first', [
				'conditions' => [
					'id' => $id,
					'school_id' => $this->Auth->user('school_id'),
				],
				'fields' => ['school_id'],
			]);
			if (empty($target_class))
			{
				return $this->redirect(['action' => 'class_list']);
			}

			if ($this->Auth->user('school_id') != $target_class['ClassRoom']['school_id'])
			{
				$this->Flash->setFlashError('不正なアクセスです。');
				return $this->redirect(['action' => 'class_list']);
			}
			$this->ClassRoom->id = $id;
		}

		// 複数削除
		if ($this->request->is('post'))
		{
			$this->ClassRoom->id = $this->request->data['deletedata'];// 複数のid
		}

		// 共通削除
		if ($this->ClassRoom->delete() == false)
		{
			$this->Flash->setFlashError('削除できませんでした。');
			return $this->redirect(['action' => 'class_list']);
		}

		$this->Flash->setFlashSuccess('削除しました。');
		return $this->redirect(['action' => 'class_list']);
	}

	public function call_student ()
	{
		$this->autoRender = FALSE;
		if($this->request->is('ajax'))
		{
			// 授業を受ける学生リスト
			$get_student = $this->StudentSubject->find('all',[
				'conditions' => [
					'subject_id' => $this->request->data['id'],
					//'school_id' => $this->Auth->user('school_id'),
				],
			]);
			
			//　学生を表示するため配列データ
			$student_name_list = [];
			foreach ($get_student as $student)
			{
				$student_name_list[] = [
					'id' => $student['Student']['id'],
					'name' => $student['Student']['name'],
					'img' => $student['Student']['image'],
					'major' => $this->Major->find('first',[
						'conditions' => [
							'id' => $student['Student']['major_id'],
							'school_id' => $this->Auth->user('school_id'),
						],
						'fields' => ['name'],
						'recursive' => -1,
					]),
				];
			}
			return json_encode($student_name_list);
		}
	}
}