<?php

class ClassRoomsController extends AppController {

	public $uses = [
		'User',
		'Student',
		'ClassRooms',
	];

	public function index ()
	{

	}

	//クラス登録
	public function add ()
	{
		if ($this->request->is('get'))
		{
			return;
		}
	}

	//クラス編集
	public function edit ($id = null)
	{

	}

	//クラス削除
	public function delete ($id = null)
	{

	}
}