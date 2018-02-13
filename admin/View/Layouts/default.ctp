<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="content-language" content="ja">
<title>出席管理|学生管理</title>
<meta name="description" content="出席管理システムは学生、教室、科目の管理ができるシステムです。">
<meta name="keywords" content="出席管理,出席管理システム,学生管理,学校管理,教室管理,学科管理,無料,attendance,student,subject,class,free,attendance_system">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<?= $this->Html->css ('../bootstrap/css/bootstrap.min.css')?>
<?= $this->Html->css ('style')?>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- bootstrap datepicker -->
<?= $this->Html->css('../dist/css/AdminLTE.min') ?>
<?= $this->Html->css('../dist/css/skins/skin-blue.min') ?>
<?= $this->Html->css('../plugins/datepicker/datepicker3')?>
<!-- daterange picker -->
<?= $this->Html->css('../plugins/daterangepicker/daterangepicker')?>
<!-- Bootstrap time Picker -->
<?= $this->Html->css('../plugins/timepicker/bootstrap-timepicker.min')?>
<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<!-- date time picker -->
<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
<!-- slide button -->
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
	<header class="main-header">
		<a href="index2.html" class="logo"><span class="logo-mini"><b>出</b>席</span><span class="logo-lg"><b>出席</b>管理</span></a>
		<!-- Header Navbar -->
		<nav class="navbar navbar-static-top" role="navigation">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle navigation</span></a>
		</nav>
	</header>

	<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="https://image.freepik.com/free-icon/user-image-with-black-background_318-34564.jpg" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p><?= $login_user ?></p>
				<a><i class="fa fa-circle text-success"></i> Online</a>
				<a href="/attendance_system/admin/users/logout/"><i class="fa fa-sign-out" aria-hidden="true"></i>logout</a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header"></li>
			<!-- Optionally, you can add icons to the links -->
			<?php if($this->request->params['controller'] == 'attendances') :?>
				<li class="active"><a href="/attendance_system/admin/attendances/index"><i class="fa fa-clock-o" aria-hidden="true"></i> <span>出席一覧</span></a></li>
			<?php else :?>
				<li><a href="/attendance_system/admin/attendances/index"><i class="fa fa-clock-o" aria-hidden="true"></i> <span>出席一覧</span></a></li>
			<?php endif ?>
			<?php if($this->request->params['controller'] == 'users') :?>
				<li class="active"><a href="/attendance_system/admin/users/index"><i class="fa fa-user" aria-hidden="true"></i><span>管理者</span></a></li>
			<?php else :?>
				<li><a href="/attendance_system/admin/users/index"><i class="fa fa-user" aria-hidden="true"></i><span>管理者</span></a></li>
			<?php endif ?>
			<?php if($this->request->params['controller'] == 'students') :?>
				<li class="treeview active"><a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>学生管理</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i>
				</span></a>
				<ul class="treeview-menu">
					<?php if($this->request->params['action'] == 'add_student') :?>
						<li class="active"><a href="/attendance_system/admin/students/add_student"><i class="fa fa-user-plus"></i>学生登録</a></li>
					<?php else :?>
						<li><a href="/attendance_system/admin/students/add_student"><i class="fa fa-user-plus"></i>学生登録</a></li>
					<?php endif ?>
					<?php if($this->request->params['action'] == 'index') :?>
						<li class="active"><a href="/attendance_system/admin/students/index"><i class="fa fa-list" aria-hidden="true"></i>学生一覧</a></li>
					<?php else:?>
						<li><a href="/attendance_system/admin/students/index"><i class="fa fa-list" aria-hidden="true"></i>学生一覧</a></li>
					<?php endif ?>
				</ul>
				</li>
			<?php else :?>
				<li class="treeview"><a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>学生管理</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
					<ul class="treeview-menu">
						<li><a href="/attendance_system/admin/students/add_student"><i class="fa fa-user-plus"></i>学生登録</a></li>
						<li><a href="/attendance_system/admin/students/index"><i class="fa fa-list" aria-hidden="true"></i>学生一覧</a></li>
					</ul>
				</li>
			<?php endif ?>
			<?php if($this->request->params['controller'] == 'subjects') :?>
				<li class="active"><a href="/attendance_system/admin/subjects/index"><i class="fa fa-book" aria-hidden="true"></i><span>学科</span></a></li>
			<?php else :?>
				<li><a href="/attendance_system/admin/subjects/index"><i class="fa fa-book" aria-hidden="true"></i><span>学科</span></a></li>
			<?php endif ?>
			<?php if($this->request->params['controller'] == 'class_rooms') :?>
				<li class="treeview active"><a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>教室管理</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
					<ul class="treeview-menu">
						<?php if($this->request->params['action'] == 'index') :?>
							<li class="active"><a href="/attendance_system/admin/class_rooms/index"><i class="fa fa-user-plus"></i>教室登録</a></li>
						<?php else :?>
							<li><a href="/attendance_system/admin/class_rooms/index"><i class="fa fa-user-plus"></i>教室登録</a></li>
						<?php endif ?>
						<?php if($this->request->params['action'] == 'class_list') :?>
							<li class="active"><a href="/attendance_system/admin/class_rooms/class_list"><i class="fa fa-list" aria-hidden="true"></i>教室一覧</a></li>
						<?php else:?>
							<li><a href="/attendance_system/admin/class_rooms/class_list"><i class="fa fa-list" aria-hidden="true"></i>教室一覧</a></li>
						<?php endif ?>
					</ul>
				</li>
			<?php else :?>
				<li class="treeview">
					<a href="#"><i class="fa fa-users" aria-hidden="true"></i><span>教室管理</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
					<ul class="treeview-menu">
						<li><a href="/attendance_system/admin/class_rooms/index"><i class="fa fa-user-plus"></i>教室登録</a></li>
						<li><a href="/attendance_system/admin/class_rooms/class_list"><i class="fa fa-list" aria-hidden="true"></i>教室一覧</a></li>
					</ul>
				</li>
			<?php endif ?>
			<!-- お知らせ -->
			<?php if($this->request->params['controller'] == 'notifications') :?>
				<li class="active"><a href="/attendance_system/admin/notifications/index"><i class="fa fa-bullhorn" aria-hidden="true"></i> <span>お知らせ</span></a></li>
			<?php else :?>
				<li><a href="/attendance_system/admin/notifications/index"><i class="fa fa-bullhorn" aria-hidden="true"></i><span>お知らせ</span></a></li>
			<?php endif ?>
			<!-- 設定 -->
			<?php if($this->request->params['controller'] == 'settings') :?>
				<li class="active"><a href="/attendance_system/admin/settings/index"><i class="fa fa-gears"></i><span>設定</span></a></li>
			<?php else :?>
				<li><a href="/attendance_system/admin/settings/index"><i class="fa fa-gears"></i><span>設定</span></a></li>
			<?php endif ?>
			<!-- お問い合わせ -->
			<li><a href="https://reg18.smp.ne.jp/regist/is?SMPFORM=merg-pfqjo-8338ee1a270877c1bc17c92ee22257f5" target="_blank"><i class="fa fa-phone" aria-hidden="true"></i><span>お問い合わせ</span></a></li>
		</ul>
	</section>
	</aside>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Main content -->
		<section class="content container-fluid">
			<?= $this->Flash->render() ?>
			<?php echo $this->fetch('content'); ?>
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="pull-right hidden-xs">
			<!-- Anything you want -->
		</div>
		<!-- Default to the left -->
		<strong>Copyright &copy; 2017 <a>HAU MUN TUANG</a>.</strong> All rights reserved.
	</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
<?= $this->Html->script('../bootstrap/js/bootstrap.min') ?>
<!-- AdminLTE App -->
<?= $this->Html->script('../dist/js/adminlte.min')?>
<?= $this->Html->script('../plugins/datatables/jquery.dataTables.min') ?>
<?= $this->Html->script('../plugins/datatables/dataTables.bootstrap.min') ?>
<?= $this->Html->script('../plugins/datepicker/bootstrap-datepicker')?>
<!-- date-range-picker -->
<?= $this->Html->script('../plugins/daterangepicker/moment.min')?>
<?= $this->Html->script('../plugins/daterangepicker/daterangepicker')?>
<!-- bootstrap time picker -->
<?= $this->Html->script('../plugins/timepicker/bootstrap-timepicker.min')?>

<!-- 日本語化 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/ja.js"></script>
<!-- date time picker -->
<script src="https://unpkg.com/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/ja.js"></script>
<!-- slide button -->
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
	$(function () {
	//日本語にする
	$.extend( $.fn.dataTable.defaults, { 
		language: {
			url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
		}
	});
	// warning msg off
	$.fn.dataTable.ext.errMode = 'none';
	$('#example1').DataTable({
		'scrollX': true
	});
});
// checkbox 複数削除したい
$(function(){
	$('.checkbox').click(function(){
		if(this.checked)
		{
			if ($('.checkbox:checked').length > 1)
			{
				$('#off').removeAttr('disabled');
			}
		} else {
			if ($('.checkbox:checked').length == 1) {
				$('#off').attr('disabled', 'disabled');
			}
		}
	})
});

// Date picker
$('#datepicker').datepicker({
	autoclose: true,
	language: 'ja',
});

// Date range picker 日本語化に
$('#reservation').daterangepicker({
	format:'YYYY/MM/DD',
	showDropdowns: false,
	opens: 'left',
	locale: {
		applyLabel: '選択',
		cancelLabel: 'クリア',
		fromLabel: '開始日',
		toLabel: '終了日',
		weekLabel: 'W',
		customRangeLabel: '自分で指定',
		daysOfWeek: moment.weekdaysMin(),
		monthNames: moment.monthsShort(),
		firstDay: moment.localeData()._week.dow
	}
});

//Timepicker
$('.timepicker').timepicker({
	showInputs: false,
});

// お知らせ登録のdatetimepicker
$(document).ready(function(){
	flatpickr('.datetimepicker', {
		enableTime: true,
		time_24hr: true,
		dateFormat: 'Y-m-d H:i',
		minDate: 'today',
		locale: 'ja',
	});
});

</script>
</body>
</html>