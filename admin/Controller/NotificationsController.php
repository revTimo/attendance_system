<?php

class NotificationsController extends AppController {
	//public $components = array('Security');
	public function index ()
	{
		$notifications = $this->Notification->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
			'order' => ['created' => 'desc'],
		]);

		$this->set('all_notifications', $notifications);
	}

	public function confirm ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
		$this->set('post_data', $this->request->data);
	}

	public function add ($id = null, $status = null)
	{
		if ($this->request->is('get'))
		{
			return;
		}
		$saveData = [
			'title' => $this->request->data['Notification']['title'],
			'content' => $this->request->data['Notification']['content'],
			'publish_at' => $this->request->data['Notification']['publish_at'],
			'school_id' => $this->Auth->user('school_id'),
		];
		// 編集
		if ($status == 28)
		{
			$this->Notification->id = $id;
			if ($this->Notification->field('school_id') != $this->Auth->user('school_id'))
			{
				$this->Flash->setFlashError('不正なアクセス');
				return $this->redirect(['action' => 'index']);
			}
		}
		// 通常
		if ($this->Notification->save($saveData) == false)
		{
			$this->Flash->setFlashError('お知らせの登録が失敗しました');
			return $this->redirect(['index']);
		}
		$this->Flash->setFlashSuccess('お知らせを登録しました '.$this->request->data['Notification']['publish_at'].' に公開されます。');
		return $this->redirect(['action' => 'index']);
	}

	public function edit ($id = null)
	{
		// validation
		// $idのチェック
		$edit_data = $this->Notification->find('first', [
			'conditions' => [
				'id' => $id,
			],
		]);
		if (empty($edit_data))
		{
			$this->Flash->setFlashError('不正なアクセス');
			return $this->redirect(['action' => 'index']);
		}
		// 他の学校をできないように
		$this->Notification->id = $id;
		if ($this->Notification->field('school_id') != $this->Auth->user('school_id'))
		{
			$this->Flash->setFlashError('不正なアクセス');
			return $this->redirect(['action' => 'index']);
		}

		$this->set('edit_notification', $edit_data);
	}

	public function delete ($id = null)
	{
		// １レコード削除
		if ($this->request->is('get'))
		{
			$delete_ids = $id;
		}
		// 複数を削除
		if ($this->request->is('post'))
		{
			$delete_ids = $this->request->data['deletedata'];
		}
		// validation
		// id null のとき
		$delete_notification = $this->Notification->find('all', [
			'conditions' => [
				'id' => $delete_ids,
			],
		]);
		//pr($delete_notification); exit;
		if (empty($delete_notification))
		{
			$this->Flash->setFlashError('不正なアクセス');
			return $this->redirect(['action' => 'index']);
		}
		// 他の学校をできないように
		foreach ($delete_notification as $check)
		{
			if ($check['Notification']['school_id'] != $this->Auth->user('school_id'))
			{
				$this->Flash->setFlashError('不正なアクセス');
				return $this->redirect(['action' => 'index']);
			}
		}

		$this->Notification->id = $delete_ids;
		// 共通削除
		if ($this->Notification->delete() == false)
		{
			$this->Flash->setFlashError('削除できませんでした。');
			return $this->redirect(['action' => 'index']);
		}

		$this->Flash->setFlashSuccess('お知らせを削除しました');
		return $this->redirect(['action' => 'index']);
	}
}