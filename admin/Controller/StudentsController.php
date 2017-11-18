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
	public function add_student ()
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
			if ($this->Student->save($this->request->data) == false)
			{
				return $this->Flash->setFlashError('学生登録失敗しました。');
			}
			return $this->Flash->setFlashSuccess('学生の登録が完了しました。');
		}
	}
}