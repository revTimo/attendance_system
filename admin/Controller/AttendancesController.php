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
		'StudentUser',
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
		foreach ($allClass as $value)
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
				'attendance_rate' => $this->attendace_rate($value['ClassRoom']['id'], $value['ClassRoom']['semester_from'], $value['ClassRoom']['semester_to'], $value['ClassRoom']['week']),
			];
		}
		$this->set('allAttendance', $allAttendance);
	}

	public function detail ($id = null, $student_id = null)
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
				//'student' => $this->StudentSubject->get_attend_student_list($value['id']),
				'student' => $this->Student->find('first', [
					'conditions' => [
						'id' => $student_id,
					],
				]),
				'date' => $d,
				'week' => $value['week'],
			];
		}
//pr($allAttendance); exit;
		$this->set('allAttendance', $allAttendance);

		$attendData = $this->Attendance->find('all', [
			'conditions' => [
				'class_id' => $id,
				'student_id' => $student_id,
			],
		]);

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
//		pr($studentAttend); exit;
		$this->set('studentAttend', $studentAttend);
	}

	public function attendace_rate($class_id = null, $semester_from = null, $semester_to = null, $week = null)
	{
		// 授業日数
		// 日付作成
		$period = new DatePeriod(
			new DateTime($semester_from),
			new DateInterval('P1D'),
			new DateTime($semester_to)
		);
		$classdays = [];
		foreach ($period as $datevalue) {
			if ($week == $datevalue->format('w'))
			{
				$classdays[] = $datevalue->format('Y-m-d');
			}
		}
		// 授業に参加している学生を取得
		$students = $this->StudentSubject->get_attend_student_list($class_id);
		$student_ids = [];
		foreach ($students as $value)
		{
			$student_ids[] = $value['id'];
		}
		$get_attendance = $this->Attendance->find('all', [
			'conditions' => [
				'class_id' => $class_id,
				'status' => ATTEND,
				'student_id' => $student_ids,
			],
			'fields' => ['student_id'],
		]);

		$attend_student = [];
		foreach ($get_attendance as $key => $student)
		{
			$attend_student[] = $student['Attendance']['student_id'];
		}

		$student_attend_list = [];
		foreach ($student_ids as $key => $id)
		{
			$student_attend_list[] = [
				'student_id' => $id,
				'rate' => [],
			];
			foreach ($attend_student as $attend_id)
			{
				if ($id == $attend_id)
				{
					array_push($student_attend_list[$key]['rate'], 1);
				}
			}
		}

		$students_attendance_rate = [];
		foreach ($student_attend_list as $key => $attend_rate)
		{
			$students_attendance_rate[] = [
				'student_id' => $attend_rate['student_id'],
				'attend_percent' => round(array_sum($attend_rate['rate'])/sizeof($classdays)*100),
			];
		}
		return $students_attendance_rate;
	}
}