<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
// 出席
define("ATTEND", 1);
// 遅れ
define("LATE", 2);
// 欠席
define("ABSENCE", 0);
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = [
		'Flash',
		'Auth' => [
			'loginAction' => [
				'controller' => 'student_users',
				'action' => 'login',
			],
			'loginRedirect' => [
				'controller' => 'student_users',
				'action' => 'index',
			],				
			'logoutRedirect' => [
				'controller' => 'student_users',
				'action' => 'login',
			],
			'authenticate' => [
				'Form' => [
					'fields'=>['username'=>'student_number', 'password' => 'password'],
					'passwordHasher' => 'Blowfish',
					'userModel' => 'StudentUser',
				],
			],
		],
	];

	public function beforeFilter()
	{
		parent::beforeFilter();
		AuthComponent::$sessionKey = 'Auth.Student';
		$this->login_student_info();
		$this->check_attendance();
		$this->side_notification();
	}
	//カスタマイズエラーメッセージ
	public function setFlashSuccess($msg)
	{
		$this->Session->setFlash($msg,'flash_success');
	}

	public function setFlashError($msg) 
	{
		$this->Session->setFlash($msg,'flash_failure');
	}

	// 出席チェック【出席ボタン押した後page reloadすると押せられないように】
	public function check_attendance ()
	{
		// temporary_attendanceに入っているattendance_idを取得
		$get_attendance_id = $this->TemporaryAttendance->find('all', [
			'conditions' => [
				'student_id' => $this->Auth->user('student_id'),
			],
			'fields' => ['attendance_id'],
		]);
		// 出席していない場合空になる
		if (empty($get_attendance_id))
		{
			$this->set('is_attending', False);
		}

		if (!empty($get_attendance_id))
		{
			$get_class = $this->Attendance->find('first', [
				'conditions' => [
					'id' => $get_attendance_id[0]['TemporaryAttendance']['attendance_id'],
				],
			]);

			$this->set('is_attending', True);
			$this->set('attending_class', $get_class['Attendance']['class_id']);

			$end_time = $this->ClassRoom->find('first', [
				'conditions' => [
					'id' => $get_class['Attendance']['class_id'],
				],
				'fields' => ['end_time'],
			]);

			if (date('H:i:s') >= $end_time['ClassRoom']['end_time'])
			{
				$this->TemporaryAttendance->deleteAll(['attendance_id' => $get_attendance_id[0]['TemporaryAttendance']['attendance_id']]);
			}
		}
	}

	// ログイン学生の情報全てを
	public function login_student_info ()
	{
		if ($this->Auth->user()) {
			$student_data = $this->Student->find('first', [
				'conditions' => [
					'student_number' => $this->Auth->user('student_number'),
				],
			]);
			// 学校名
			$school_name = $this->School->find('first', [
				'conditions' => [
					'id' => $student_data['Student']['school_id'],
				],
				'fields' => ['name'],
			]);
			// 専攻名
			$major_name = $this->Major->find('first', [
				'conditions' => [
					'id' => $student_data['Student']['major_id'],
				],
				'fields' => ['name'],
			]);

			// 学科
			if (!empty($major_name))
			{
				$all_subject = $this->StudentSubject->find('all', [
					'conditions' => [
						'student_id' => $student_data['Student']['id'],
					],
				]);
				$subjects_id = [];
				foreach ($all_subject as $key => $value) {
					$subjects_id[] = $all_subject[$key]['StudentSubject']['subject_id'];
				}
				$subject_list = $this->Subject->find('all', [
					'conditions' => [
						'id' => $subjects_id,
					],
					'fields' => ['name'],
				]);
				$subject_name = [];
				foreach ($subject_list as $key => $value) {
					$subject_name[] = $value['Subject']['name'];
				};
			}
			// 専攻が未登録$major_name['Major']['name']
			if (empty($major_name))
			{
				$major_name['Major']['name'] = '未登録';
				$subject_name = ['未登録'];
			}
			$info = [
				'id' => $student_data['Student']['id'],
				'name' => $student_data['Student']['name'],
				'major' => $major_name['Major']['name'],
				'subjects' => $subject_name,
				'school_name' => $school_name['School']['name'],
				'grade' => $student_data['Student']['grade'],
				'school_id' => $student_data['Student']['school_id'],
			];
			$this->set('student_info', $info);
		}
	}

	public function get_class($student_id)
	{
		// 学生が参加しているクラス全てを取得
		$student_class = $this->ClassStudent->find('all', [
			'conditions' => [
				'student_id' => $student_id,
			],
		]);
		$class_ids = [];
		foreach ($student_class as $value) {
			$class_ids[] = $value['ClassStudent']['class_room_id'];
		}

		// 授業の詳細
		$class_detail = $this->ClassRoom->find('all', [
			'conditions' => [
				'id' => $class_ids,
			],
		]);

		$class = [];

		foreach ($class_detail as $key => $value) {
			$class[] = [
				'id' => $value['ClassRoom']['id'],
				'name' => $value['ClassRoom']['name'],
				'subject' => $this->Subject->find('first', [
					'conditions' => [
						'id' => $value['ClassRoom']['subject_id'],
					],
					'fields' => ['id', 'name'],
				]),
				'grade' => $value['ClassRoom']['grade'],
				'start_time' => $value['ClassRoom']['start_time'],
				'end_time' => $value['ClassRoom']['end_time'],
				'week' => $value['ClassRoom']['week'],
			];
		}
		return $class;
	}

	// 出席処理
	public function attend_class($class_id = null)
	{
		// まずセキュリティーチェック
		$find_class = $this->ClassRoom->find('first', [
			'conditions' => [
				'id' => $class_id,
			],
		]);
		if (empty($find_class))
		{
			return false;
		}
		if ($this->Auth->user('school_id') != $find_class['ClassRoom']['school_id'] )
		{
			return false;
		}
		// postされたクラスidで、class_studentの中からstudent_id & school_id をだす
		$data = $this->ClassStudent->find('first', [
			'conditions' => [
				'class_room_id' => $class_id,
				'student_id' => $this->Auth->user('student_id'),
			],
			'fields' => ['student_id', 'school_id'],
		]);
		$student_id = $data['ClassStudent']['student_id'];
		$school_id = $data['ClassStudent']['school_id'];

		// ip address取得
		$ip_address = $this->request->clientIP();

		//　データーが全て揃ったら出席した時間をチェックする
		$status;
		$class_start_time = $find_class['ClassRoom']['start_time'];
		$current_time = date("H:i:s");
		// 時間以内 status:1
		if ($current_time <= $class_start_time)
		{
			$status = ATTEND;
		}

		// 5min
		$late_limit_time = date('H:i:s', strtotime("+5minutes", strtotime($class_start_time)));
		// 遅刻 or 欠席
		if ($current_time > $class_start_time)
		{
			// 遅刻
			if ($current_time <= $late_limit_time)
			{
				$status = LATE;
				// 遅刻が3回の場合欠席その授業のその日が欠席  status:0
				// この場合毎度ＤＢの中を見る必要がありますね
			}
			//　欠席
			else
			{
				$status = ABSENCE;
			}
		}

		// 保存
		$attend_data = [
			'class_id' => $class_id,
			'student_id' => $student_id,
			'status' => $status,
			'ip_address' => $ip_address,
			'school_id' => $school_id,
			'class_start_at' => $class_start_time,
			'student_attend_at' => $current_time,
		];

		return $attend_data;
	}

	// お知らせ
	public function side_notification()
	{
		// とりあえず一覧
		// 次は conditions => student_id
		$side_notifications = $this->Notification->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
				'publish_at <=' => date('Y-m-d H:i'),
			],
			'order' => [
				'created' => 'DESC',
			],
			'limit' => 3,
		]);
		$this->set('side_notifications', $side_notifications);
	}
}