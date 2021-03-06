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

// 管理者
define ('ADMIN',1);
// 一般メンーバ
define ('MEMBER',0);
// 遅刻時間が設定されている
define ('SET_LATE', 1);
// 遅刻時間をリセット
define ('UNSET_LATE', 0);
// 出席
define("ATTEND", 1);
// 遅れ
define("LATE", 2);
// 欠席
define("ABSENCE", 0);

class AppController extends Controller {

	public function beforeFilter ()
	{
		AuthComponent::$sessionKey = 'Auth.Admin';
		$this->user_info();
	}

	public function set($var, $val = null, $sanitize = true)
	{
		if ($sanitize)
		{
			$val = $this->__sanitize($val);
		}
		return parent::set($var, $val);
	}

	private function __sanitize($dat)
	{
		if (is_array($dat))
		{
			foreach ($dat as $cnt => $val)
			{
				$dat[$cnt] = $this->__sanitize($val);
			}
			return $dat;
		} else {
			return htmlspecialchars($dat);
		}
	}

	public $components = [
		//'Security',
		'Flash',
		'Auth' => [
			'loginRedirect' => [
				'controller' => 'attendances',
				'action' => 'index',
			],				
			'logoutRedirect' => [
				'controller' => 'users',
				'action' => 'login',
			],
			'authenticate' => [
				'Form' => [
					'fields'=>['username'=>'email'],
					'passwordHasher' => 'Blowfish',
					'userModel' => 'User',
				],
			],
		],
	];

	//カスタマイズエラーメッセージ
	public function setFlashSuccess($msg)
	{
		$this->Session->setFlash($msg,'flash_success');
	}

	public function setFlashError($msg) 
	{
		$this->Session->setFlash($msg,'flash_failure');
	}

	//Method -> Post のみ
	public function if_get ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
	}

	//ログインユーザーの取得
	public function user_info()
	{
		if($this->Auth->user())
		{
			$this->set('login_user',$this->Auth->user('name'));
		}
	}

	// 学生編集と詳細ページ用
	public function get_student($id = null)
	{
		$search_student = $this->Student->find('first', [
			'conditions' => [
				'id' => $id,
				'school_id' => $this->Auth->user('school_id'),
			],
		]);

		if (empty($search_student))
		{
			return $this->redirect(['action' => 'index']);
		}
		//自分の学校以外を編集できないようにする
		if ($this->Auth->user('school_id') != $search_student['Student']['school_id'])
		{
			return $this->redirect(['action' => 'index']);
		}
		$this->set('edit_student', $search_student);
	}

}
