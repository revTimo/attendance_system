<?php

class SettingsController extends AppController {
	private $setting_info = [];
	public function beforeFilter()
	{
		parent::beforeFilter();
		$this->check_setting();
	}
	public function check_setting()
	{
		$check = $this->Setting->find('first', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);
		if ($check['Setting']['is_set'] == SET_LATE)
		{
			$this->setting_info['is_set'] = SET_LATE;
			$this->setting_info['value'] = $check['Setting']['late_limit_time'];
		}
		if ($check['Setting']['is_set'] == UNSET_LATE)
		{
			$this->setting_info['is_set'] = UNSET_LATE;
			$this->setting_info['value'] = "";
		}
	}
	public function index ()
	{
		$this->set('setting_info', $this->setting_info);
	}

	public function set_latetime ()
	{
		if ($this->request->is('get'))
		{
			return;
		}

		$this->Setting->id = $this->Setting->find('list', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);

		$setting_data = [
			'late_limit_time' => $this->request->data['Setting']['late_limit_time'],
			'is_set' => SET_LATE,
		];
		if ($this->Setting->save($setting_data) == false)
		{
			$this->Flash->setFlashError('時間設定失敗しました');
			return $this->redirect(['action' => 'index']);
		}
		$this->Flash->setFlashSuccess('遅刻時間を設定しました。');
		return $this->redirect(['action' => 'index']);
	}

	public function set_default ()
	{
		$this->autoRender = FALSE;
		if ($this->request->is('ajax'))
		{
			$this->Setting->id = $this->Setting->find('list', [
				'conditions' => [
					'school_id' => $this->Auth->user('school_id'),
				],
			]);
			$setting_data = [
				'late_limit_time' => 5,
				'is_set' => UNSET_LATE,
			];
			if ($this->Setting->save($setting_data) == false)
			{
				$code = 400;
				return $code;
			}

			$code = 200;
			return $code;
		}
	}
}