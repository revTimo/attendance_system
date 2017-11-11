<?php
App::uses('CakeEmail','Network/Email');
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');

class UsersController extends AppController {
	public $uses = [
		'User',
		'School',
	];

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
			'fields' => ['id', 'name']
		]);
		$this->set('user_name', $this->Auth->user('name'));
		$this->set('admin_users', $admin_list);
	}

	//ログイン画面
	public function login ()
	{
		$this->layout = 'login_register';
		
		//Method -> Post のみ
		if ($this->request->is('get'))
		{
			return;
		}

		$email = $this->request->data['User']['email'];
		$password = $this->request->data['User']['password'];
		//入力バリテーション
		if ($email == '' || $password == '')
		{
			return $this->Flash->setFlashError('入力してください。');
		}
		
		//ログイン失敗
		if ($this->Auth->login() == false)
		{
			return $this->Flash->setFlashError('ユーザー名かパスワードが間違っています');	
		}
		//ログイン成功
		return $this->redirect($this->Auth->redirect());
	}

	public function register ($status = null)
	{
		$this->layout = 'login_register';
		//method -> post のみ
		if ($this->request->is('get'))
		{
			return;
		}
		$email = $this->request->data['User']['email'];
		$password = $this->request->data['User']['password'];
		
		//入力バリテーション
		if ($email == '' || $password == '')
		{
			return $this->Flash->setFlashError('入力してください。');
		}
	
		$request_data = $this->request->data['User'];
		//学校登録
		$school = [
			'name' => $request_data['school_name']
		];

		try
		{
			$this->User->begin();
			//学校登録
			if ($this->School->save($school) == false)
			{
				$this->School->rollback();
				return $this->Flash->setFlashError('学校登録失敗');
			}

			$user_data = [
				'school_id' => $this->School->id,
				'name' => $request_data['user_name'],
				'email' => $request_data['email'],
				'password' => $request_data['password']
			];
			//ユーザー登録
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

		//成功
		$this->Flash->setFlashSuccess('登録完了');
		return $this->redirect(['action' => 'login']);
	}

	//ユーザー編集
	public function edit ()
	{
		//現在ログインユーザーのことを編集する
		$current_user = $this->User->find('first', [
			'conditions' => [
				'id' => $this->Auth->user('id'),
			],
		]);
		$this->set('edit_data', $current_user);

		if ($this->request->is('post'))
		{
			//パスワードチェック
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

	//管理者追加
	public function add_member ()
	{
		if ($this->request->is('get'))
		{
			return;
		}	
	}

	//ユーザー削除
	public function delete ($id = null)
	{
		pr('delete page access complete'.$id);
		exit;
	}

	public function logout ()
	{
		return $this->redirect($this->Auth->logout());
	}
}