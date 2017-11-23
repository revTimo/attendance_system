<?php

class StudentsController extends AppController {
	public $uses = [
		'User',
		'Student',
		'Subject',
		'Major',
	];

	//学生一覧
	public function index ()
	{
		//学生を取得
		$all_student = $this->Student->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		$this->set('all_student', $all_student);

		//専攻名を取得
		$major = $this->Major->find('list', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		$this->set('major', $major);
	}

	//学生登録
	public function add_student ($sign = null, $id = null)
	{
		//専攻登録のため、select2の一覧が必要
		$all_major = $this->Major->find('list', [
			'confitions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
			'fields' => ['id', 'name'],
			//join テーブルなしで
			'recursive' => -1,
		]);
		$this->set('all_major', $all_major);

		//学生登録
		if ($this->request->is('post'))
		{
			//画像がない場合デフォルトの画像を
			$profile_img = "no_image.jpg";
			//プロフィル画像をアップロード
			if (isset($this->request->data['Student']['image']['name']))
			{
				move_uploaded_file($this->request->data['Student']['image']['tmp_name'],'../webroot/student_image/'.$this->request->data['Student']['image']['name']);
				$profile_img = $this->request->data['Student']['image']['name'];
			}
			$save_data = [
				'name' => $this->request->data['Student']['name'],
				'student_number' => $this->request->data['Student']['student_number'],
				'grade' => $this->request->data['Student']['grade'],
				'school_id' => $this->Auth->user('school_id'),
				'major_id' => $this->request->data['Student']['major_id'],
				'email' => $this->request->data['Student']['email'],
				'image' => $profile_img,
			];

			// 編集画面の場合
			if ($sign == 28)
			{
				$this->Student->id = $id;
			}

			if ($this->Student->save($save_data) == false)
			{
				return $this->Flash->setFlashError('学生登録失敗しました。');
			}

			// 編集画面の場合
			if ($sign == 28)
			{
				$this->Flash->setFlashSuccess('学生の情報を編集しました。');
				return $this->redirect(['action' => 'index']);
			}
			//　通常登録のとき
			$this->Flash->setFlashSuccess('学生の登録が完了しました。');
			return $this->redirect(['action' => 'index']);
		}
	}

	//学生編集
	public function edit ($id = null)
	{
		// AppControllerに
		$this->get_student($id);

		$all_major = $this->Major->find('list', [
			'confitions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
			'fields' => ['id', 'name'],
			//join テーブルなしで
			'recursive' => -1,
		]);
		$this->set('all_major', $all_major);
	}

	// 学生の詳細ページ
	public function detail ($id = null, $major_id = null)
	{
		// AppControllerに
		$this->get_student($id);

		$all_major = $this->Major->find('first', [
			'conditions' => [
				'id' => $major_id,
				'school_id' => $this->Auth->user('school_id'),
			],
			'fields' => ['id', 'name'],
		]);
		if (empty($all_major))
		{
			$this->Flash->setFlashError('不正アクセス');
			return $this->redirect(['action' => 'index']);;
		}
		$this->set('major', $all_major);
	}

	//学生削除
	public function delete ($id = null)
	{
		// 他の学校のIDを削除しないように
		$check = $this->Student->find('first', [
			'conditions' => [
				'id' => $id,
				'school_id' => $this->Auth->user('school_id'),
			],
			'fields' => ['school_id'],
		]);

		if (empty($check))
		{
			return $this->redirect(['action' => 'index']);
		}

		if ($this->Auth->user('school_id') != $check['Student']['school_id'])
		{
			return $this->redirect(['action' => 'index']);
		}

		$this->Student->id = $id;
		if ($this->Student->delete() == false)
		{
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->setFlashSuccess('削除しました。');
		return $this->redirect(['action' => 'index']);
	}
}