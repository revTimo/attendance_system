<?php

class AttendancesController extends AppController {
	public $uses = [
		'User',
		'Student',
		'ClassRoom',
		'Major',
		'Subject',
		'StudentSubject',
		'ClassStudent',
		'Attendance',
	];
	public function index ()
	{
		// retrive all attendance list
		$list = $this->Attendance->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			]
		]);
		$show_list = [];
		foreach ($list as $key => $value)
		{
			$show_list[] = [
				'class_name' => $this->ClassRoom->find('first', [
					'conditions' => [
						'id' => $list[$key]['Attendance']['class_id'],
					],
					'fields' => ['name'],
				]),
				'student_name' => $this->Student->find('first', [
					'conditions' => [
						'id' => $list[$key]['Attendance']['student_id'],
					],
					'fields' => ['name'],
				]),
				'status' => $list[$key]['Attendance']['status'],
				'ip_address' => $list[$key]['Attendance']['ip_address'],
				'class_start_at' => $list[$key]['Attendance']['class_start_at'],
				'student_attend_at' => $list[$key]['Attendance']['student_attend_at'],
				'created' => $list[$key]['Attendance']['created'],

			];
		}
		$this->set('attendance_list', $show_list);
	}
}