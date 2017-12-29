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
				'name' => $student_data['Student']['name'],
				'major' => $major_name['Major']['name'],
				'subjects' => $subject_name,
				'school_name' => $school_name['School']['name'],
				'grade' => $student_data['Student']['grade'],
			];
			$this->set('student_info', $info);
		}
	}
}