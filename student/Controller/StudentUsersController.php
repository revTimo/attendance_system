<?php
App::uses('BlowfishPasswordHasher','Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');
class StudentUsersController extends AppController {
	public $uses = [
		'Student',
		'StudentUser',
		'School',
		'Major',
		'StudentSubject',
		'Subject',
		'ClassStudent',
		'ClassRoom',
		'Attendance',
		'TemporaryAttendance',
		'Notification',
	];

	// ページネーション
	public $components = ['Paginator'];

	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('register', 'login');
	}
	public function index ()
	{
		$current_student = $this->Student->find('first', [
			'conditions' => [
				'student_number' => $this->Auth->user('student_number'),
				'school_id' => $this->Auth->user('school_id'),
			],
		]);

		// 出席授業
		$available_class = $this->get_class($current_student['Student']['id']);
		$this->set('all_class', $available_class);
	}

	public function login ()
	{
		$this->layout = 'login_register';
		if ($this->request->is('post'))
		{
			$student_number = $this->request->data['StudentUser']['student_number'];
			$password = $this->request->data['StudentUser']['password'];
			// 入力バリテーション
			if ($student_number == '' || $password == '')
			{
				return $this->Flash->setFlashError('入力してください。');
			}

			if ($this->Auth->login() == false)
			{
				return $this->Flash->setFlashError('ユーザー名かパスワードが間違っています');	
			}
			// ログイン成功
			return $this->redirect(['action' => 'index']);
		}
	}

	public function register ()
	{
		$this->layout = 'login_register';
		if ($this->request->is('post'))
		{
			if ($this->request->data['StudentUsers']['student_number'] == '')
			{
				return $this->Flash->setFlashError('入力してください。');
			}
			// 学生番号を管理側のstudentテーブルにあるかを探す
			$find_student = $this->Student->find('first', [
				'conditions' => [
					'student_number' => $this->request->data['StudentUsers']['student_number'],
				],
			]);
			if (empty($find_student))
			{
				return $this->Flash->setFlashError('学生番号が登録されていませんでした。');
			}
			$data = [
				'student_id' => $find_student['Student']['id'],
				'name' => $find_student['Student']['name'],
				'password' => substr(md5(uniqid(rand(),'')),0,10),
				'student_number' => $find_student['Student']['student_number'],
				'school_id' => $find_student['Student']['school_id'],
				'email' => $find_student['Student']['email'],
				'profile_img' => 'no_image.jpg',
			];		
			// if ある　仮パスワードど作成name to student numberを保存、メール送信
			try
			{
				$this->StudentUser->begin();
				if ($this->StudentUser->save($data) === false)
				{
					$this->StudentUser->rollback();
					$this->Flash->setFlashError('アカウント発行できませんでした');
					return $this->redirect(['action' => 'register']);
				}
				if ($this->StudentUser->student_account_create_mail($data) === false)
				{
					$this->StudentUser->rollback();
					$this->Flash->setFlashError('アカウント発行できませんでした・メール送信失敗');
					return $this->redirect(['action' => 'register']);
				}

				$this->StudentUser->commit();
				$this->Flash->setFlashSuccess('アカウント発行が完了しました');
				return $this->redirect(['action' => 'login']);
			}
			catch(Exception $e)
			{
				$this->StudentUser->rollback();
				$this->Flash->setFlashError('アカウント発行失敗しました'."\n".$e);
				return $this->redirect(['action' => 'register']);
			}
		}
	}

	public function edit ()
	{
		if ($this->request->is('get'))
		{
			return $this->redirect(['action' => 'index']);
		}
		// 入力バリテーション
		if ($this->request->data['StudentUser']['current_password'] == '' || $this->request->data['StudentUser']['new_password'] == '')
		{
			$this->Flash->setFlashError('パスワードを入力してください');
			return $this->redirect(['action' => 'index']);
		}
		$get_pw = $this->StudentUser->find('first', [
			'conditions' => [
				'id' => $this->Auth->user('id'),
			],
			'fields' => ['password'],
		]);
		if (Security::hash($this->request->data['StudentUser']['current_password'], 'blowfish', $get_pw['StudentUser']['password']) != $get_pw['StudentUser']['password'])
		{
			$this->Flash->setFlashError('現在のパスワードが一致していません。');
			return $this->redirect(['action' => 'index']);
		}
		$this->StudentUser->id = $this->Auth->user('id');
		if ($this->StudentUser->saveField('password', $this->request->data['StudentUser']['new_password']) === false)
		{
			return $this->Flash->setFlashError('失敗しました');
		}
		
		$this->Flash->setFlashSuccess('パスワードを変えました');
		return $this->redirect(['action' => 'index']);
	}

	public function logout ()
	{
		return $this->redirect($this->Auth->logout());
	}

	public function attend ()
	{
		if ($this->request->is('get'))
		{
			return $this->redirect(['controller' => 'student_users', 'action' => 'index']);
		}
		// json通信
		$this->autoRender = FALSE;
		if($this->request->is('ajax'))
		{
			$attend_data = $this->attend_class($this->request->data['class_id']);
			if ($attend_data == false)
			{
				$code = 400;
				$response = [
					'code' => $code,
					'class' => $this->request->data['class_id'],
				];
				return json_encode($response);
			}
			
			// 出席ＤＢ保存
			if ($this->Attendance->save($attend_data) == false)
			{
				$code = 400;
				$response = [
					'code' => $code,
					'class' => $this->request->data['class_id'],
				];
				return json_encode($response);
			}
			
			// temporary_attendance保存
			$temp_data = [
				'attendance_id' => $this->Attendance->id,
				'student_id' => $attend_data['student_id'],
			];
			if ($this->TemporaryAttendance->save($temp_data) == false)
			{
				$code = 400;
				$response = [
					'code' => $code,
					'class' => $this->request->data['class_id'],
				];
				return json_encode($response);
			}

			$code = 200;
			$response = [
				'code' => $code,
				'class' => $this->request->data['class_id'],
			];
			return json_encode($response);
		}
	}

	//　時間割
	public function timetable ()
	{
		$current_student = $this->Student->find('first', [
			'conditions' => [
				'student_number' => $this->Auth->user('student_number'),
				'school_id' => $this->Auth->user('school_id'),
			],
		]);

		// 出席授業
		$available_class = $this->get_class($current_student['Student']['id']);
		$this->set('all_class', $available_class);
	}

	//　お知らせ一覧
	public function notification()
	{
		$this->Paginator->settings = [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
				'publish_at <=' => date('Y-m-d H:i'),
			],
			'order' => [
				'created' => 'DESC',
			],
			'limit' => 3,
		];

		$notifications = $this->Paginator->paginate('Notification');
		$this->set('show_all_notifications', $notifications);
	}

	// お知らせidの詳細
	public function notification_detail ($id = null)
	{
		// validation
		// id が存在しない　あるいは　空
		$check_notification = $this->Notification->find('first', [
			'conditions' => [
				'id' => $id,
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		if (empty($check_notification))
		{
			return $this->redirect(['action' => 'index']);
		}
		// 他の学校をできないように
		if ($check_notification['Notification']['school_id'] != $this->Auth->user('school_id'))
		{
			return $this->redirect(['action' => 'index']);
		}
		$this->set('notification_detail', $check_notification);
	}
}