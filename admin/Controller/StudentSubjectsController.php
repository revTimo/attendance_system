<?php

class StudentSubjectsController extends AppController {
	public $uses = [
		'User',
		'Student',
		'Subject',
		'Major',
		'StudentSubject',
	];
}