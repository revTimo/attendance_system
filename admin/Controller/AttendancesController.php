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
		// 出席一覧いくつ表示するかを決める
		$allClass = $this->ClassRoom->find('all', [
			'conditions' => [
				'school_id' => $this->Auth->user('school_id'),
			],
		]);

		$allAttendance = [];
		// 参加学生リスト
		foreach ($allClass as $key => $value)
		{

			$allAttendance[] = [
				'class_id' => $value['ClassRoom']['id'],
				'class_name' => $value['ClassRoom']['name'],
				'subject' => $this->Subject->find('first', [
					'conditions' => ['id' => $value['ClassRoom']['subject_id']],
					'fields' => ['name'],
				]),
				'semester_from' => $value['ClassRoom']['semester_from'],
				'semester_to' => $value['ClassRoom']['semester_to'],
				'student' => $this->StudentSubject->get_attend_student_list($value['ClassRoom']['id']),
			];
		}
		$this->set('allAttendance', $allAttendance);
	}

	public function detail ($id = null)
	{
		// parameter check

		$allClass = $this->ClassRoom->find('first', [
			'conditions' => [
				'id' => $id,
			],
		]);

		if (!$allClass)
		{
			return $this->redirect(['action' => 'index']);
		}

		if ($allClass['ClassRoom']['school_id'] != $this->Auth->user('school_id'))
		{
			return $this->redirect(['action' => 'index']);
		}
		// pr($allClass); exit;
		$allAttendance = [];
		// 参加学生リスト
		foreach ($allClass as $key => $value)
		{
			// 日付作成
			$period = new DatePeriod(
				new DateTime($value['semester_from']),
				new DateInterval('P1D'),
				new DateTime($value['semester_to'])
			);
			foreach ($period as $datevalue) {
				if ($value['week'] == $datevalue->format('w'))
				{
					$d[] = [
						'day' => $datevalue->format('Y-m-d'),
						'week' => $datevalue->format('w'),
					];
				}
			}

			$allAttendance = [
				'class_id' => $value['id'],
				'class_name' => $value['name'],
				'subject' => $this->Subject->find('first', [
					'conditions' => ['id' => $value['subject_id']],
					'fields' => ['name'],
				]),
				'semester_from' => $value['semester_from'],
				'semester_to' => $value['semester_to'],
				'student' => $this->StudentSubject->get_attend_student_list($value['id']),
				'date' => $d,
				'week' => $value['week'],
			];
		}
//pr($allAttendance); exit;
		$this->set('allAttendance', $allAttendance);

		$attendData = $this->Attendance->find('all', [
			'conditions' => [
				'class_id' => $id,
			],
		]);
// pr($attendData); exit;
		// 日付を比較してあったら同じの場合statusをadd
		$studentAttend = [];
		foreach ($allAttendance['date'] as $semester_value)
		{
			foreach ($attendData as $attend_value)
			{
				if ($semester_value['day'] == date("Y-m-d", strtotime($attend_value['Attendance']['created'])))
				{
					$studentAttend[] = [
						'date' => $semester_value,
						'student_id' => $attend_value['Attendance']['student_id'],
						'status' => $attend_value['Attendance']['status'],
					];
				}
			}
		}
		//pr($studentAttend); exit;
		$this->set('studentAttend', $studentAttend);
	}
}