<?php
App::uses('CakeEmail','Network/Email');
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');

class UsersController extends AppController {
	public $uses = [
		'User',
		'School',
		'Major',
	];
	public $components = array('Session');
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('register');
	}

	//管理者一覧
	public function index ()
	{
		$admin_list = $this->User->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
			'fields' => ['id', 'name', 'is_admin'],
		]);
		$this->set('current_user_id', $this->Auth->user('id'));
		$this->set('admin_users', $admin_list);
		$this->set('current_user', $this->Auth->user('is_admin'));
	}

	//ログイン画面
	public function login ()
	{
		$this->layout = 'login_register';
		
		// Method -> Post のみ
		if ($this->request->is('get'))
		{
			return;
		}

		$email = $this->request->data['User']['email'];
		$password = $this->request->data['User']['password'];
		// 入力バリテーション
		if ($email == '' || $password == '')
		{
			return $this->Flash->setFlashError('入力してください。');
		}
		
		// ログイン失敗
		if ($this->Auth->login() == false)
		{
			return $this->Flash->setFlashError('ユーザー名かパスワードが間違っています');	
		}
		// ログイン成功
		return $this->redirect($this->Auth->redirect());
	}

	public function register ($status = null)
	{
		$this->layout = 'login_register';
		// method -> post のみ
		if ($this->request->is('get'))
		{
			return;
		}
		$email = $this->request->data['User']['email'];
		$password = $this->request->data['User']['password'];
		
		// 入力バリテーション
		if ($email == '' || $password == '')
		{
			return $this->Flash->setFlashError('入力してください。');
		}
	
		$request_data = $this->request->data['User'];
		// 学校登録
		$school = [
			'name' => $request_data['school_name']
		];

		try
		{
			$this->User->begin();
			// 学校登録
			if ($this->School->save($school) == false)
			{
				$this->School->rollback();
				return $this->Flash->setFlashError('学校登録失敗');
			}

			$user_data = [
				'school_id' => $this->School->id,
				'name' => $request_data['user_name'],
				'email' => $request_data['email'],
				'password' => $request_data['password'],
				'is_admin' => ADMIN,
			];
			// ユーザー登録
			if ($this->User->save($user_data) == false)
			{
				$this->User->rollback();
				return $this->Flash->setFlashError('登録できませんでした');
			}			
			$this->User->commit();
		}
		catch (Exception $e)
		{
			$this->User->rollback();
			return $this->Flash->setFlashError('登録できませんでした。');
		}

		// 成功
		$this->Flash->setFlashSuccess('登録完了');
		return $this->redirect(['action' => 'login']);
	}

	// ユーザー編集
	public function edit ()
	{
		// 現在ログインユーザーのことを編集する
		$current_user = $this->User->find('first', [
			'conditions' => [
				'id' => $this->Auth->user('id'),
			],
		]);
		$this->set('edit_data', $current_user);

		if ($this->request->is('post'))
		{
			// パスワードチェック
			$this->User->id = $current_user['User']['id'];
			if (Security::hash($this->request->data['User']['old_password'], 'blowfish', $current_user['User']['password']) != $current_user['User']['password'])
			{
				return $this->Flash->setFlashError('以前のパスワードが一致していません。');
			}

			if ($this->User->save($this->request->data) === false)
			{
				return $this->Flash->setFlashError('編集失敗しました');
			}
			$this->Flash->setFlashSuccess('アカウント編集完了しました');
			$this->redirect(['action' => 'index']);
		}
	}

	// 管理者・メンバーstatus変える
	public function change_status ($id = null, $condition = null)
	{
		// 管理者のみ
		if ($this->Auth->user('is_admin') != ADMIN )
		{
			$this->Flash->setFlashError('管理者以外アクセスできません。');
			return $this->redirect(['action'=>'index']);
		}

		// 権限を変えるユーザーが他校のユーザーにならないように
		$target_id_check = $this->User->find('first',[
			'conditions' => [
				'id' => $id,
			],
			'fields' => ['school_id'],
		]);

		if (empty($target_id_check))
		{
			$this->Flash->setFlashError('不正なアクセス。');
			return $this->redirect(['action'=>'index']);
		}

		if ($this->Auth->user('school_id') != $target_id_check['User']['school_id'])
		{
			$this->Flash->setFlashError('不正なアクセス。');
			return $this->redirect(['action'=>'index']);
		}

		// 管理者が一人以下なのに引退しようとしたら
		$admin_count = $this->User->find('count', [
			'fields' => 'is_admin',
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
				'is_admin' => ADMIN,
			],
		]);

		$this->User->id = $id;

		switch ($condition)
		{
			case 'make_admin':
			{
				$this->User->saveField('is_admin', ADMIN);
				return $this->redirect(['action' => 'index']);
			}

			case 'retire':
			{
				// もし管理者が一人しかいない場合
				if ($admin_count <= 1)
				{
					$this->Flash->setFlashError('管理者が1人しかいない為、管理者から外れることはできません');
					return $this->redirect(['action' => 'index']);
				}
				$this->User->saveField('is_admin', MEMBER);
				/*
				 * is_adminデータが更新されてもログイン中のユーザーの情報は変わっていない
				 * なので、Sessionの中のユーザー情報の更新
				 */ 
				$user = $this->User->find('first', [
					'recursive' => -1,
					'conditions' => [
						'id' => $this->Auth->user('id'),
					],
				
				]);
				$this->Session->write('Auth', $user);
				return $this->redirect(['action' => 'index']);
			}
		}
	}

	// 管理者追加
	public function add_member ()
	{
		if ($this->request->is('get'))
		{
			return;
		}

		$member = [
			'school_id' => $this->Auth->user('school_id'),
			'name' => $this->request->data['User']['name'],
			'email' => $this->request->data['User']['email'],
			'password' => substr(md5(uniqid(rand(),'')),0,10),
		];
		
		try
		{
			$this->User->begin();
			if ($this->User->save($member) === false)
			{
				$this->User->rollback();
				$this->Flash->setFlashError('メンバー追加できませんでした・保存失敗');
				return $this->redirect(['action' => 'index']);
			}

			if ($this->User->member_invite_mail($member) === false)
			{
				$this->User->rollback();
				$this->Flash->setFlashError('メンバー追加できませんでした・メール送信失敗');
				return $this->redirect(['action' => 'index']);
			}

			$this->User->commit();
			$this->Flash->setFlashSuccess('メンバーが招待されました。');
			return $this->redirect(['action' => 'index']);
		}
		catch(Exception $e)
		{
			$this->User->rollback();
			$this->Flash->setFlashError('メンバー追加できませんでした'."\n".$e);
			return $this->redirect(['action' => 'index']);
		}
	}

	// ユーザー削除
	public function delete ($id = null)
	{
		// 他の学校のIDを削除しないように
		$current = $this->User->find('first', [
			'conditions' => [
				'id' => $id,
			],
			'fields' => ['school_id'],
		]);
		if (empty($current))
		{
			return $this->redirect(['action' => 'index']);
		}
		if ($current['User']['school_id'] != $this->Auth->user('school_id'))
		{
			return $this->redirect(['action' => 'index']);
		}
		$this->User->id = $id;
		if ($this->User->delete() == false)
		{
			return $this->Flash->setFlashError('削除できませんでした');
		}

		$this->Flash->setFlashSuccess('削除しました');
		return $this->redirect(['action' => 'index']);
	}

	public function logout ()
	{
		return $this->redirect($this->Auth->logout());
	}
}