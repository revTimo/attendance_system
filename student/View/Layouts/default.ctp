<!DOCTYPE html>
<html lang="jp">
<head>
<title>出席管理システム</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<?= $this->Html->css ('style.css') ?>
<?= $this->Html->css ('passwordmodalstyle') ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.1.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FitText.js/1.1/jquery.fittext.min.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<!-- <a class="navbar-brand" href="#">Logo</a> -->
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<?php if($this->request->params['action'] == 'index') :?>
				<li class="active"><a href="/attendance_system/student/StudentUsers/index">ホーム</a></li>
				<?php else :?>
				<li><a href="/attendance_system/student/StudentUsers/index">ホーム</a></li>
				<?php endif ?>
				<?php if($this->request->params['action'] == 'timetable') :?>
				<li class="active"><a href="/attendance_system/student/StudentUsers/timetable">時間割</a></li>
				<?php else :?>
				<li><a href="/attendance_system/student/StudentUsers/timetable">時間割</a></li>
				<?php endif ?>
				<?php if($this->request->params['action'] == 'notification') :?>
				<li class="active"><a href="/attendance_system/student/StudentUsers/notification">お知らせ</a></li>
				<?php else :?>
				<li><a href="/attendance_system/student/StudentUsers/notification">お知らせ</a></li>
				<?php endif ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#" data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-lock"></span>パスワードを変える</a></li>
				<li><a href="/attendance_system/student/student_users/logout"><span class="glyphicon glyphicon-log-out"></span> ログアウト</a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="container text-center">
	<div class="row">
		<div class="col-sm-3 well">
			<div class="well">
				<p><a href="#"><?=$student_info['name']?></a></p>
				<p><?=$student_info['grade']." 年 ".$student_info['major']?></p>
				<?= $this->Html->image('../profile/no_image.jpg',["class" => "img-circle", "width" => "65", "height" => "65"])?>
			</div>
			<div class="well">
				<p>受ける科目全て</p>
				<p>
				<?php foreach($student_info['subjects'] as $subject) :?>
				<span class="label label-default"><?= $subject?></span>
				<?php endforeach ?>
				</p>
			</div>
			<div class="alert alert-danger fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<p><strong>重要なお知らせ!</strong></p>
				People arefsdfs looking at your profile. Find out whosdfgdf.
			</div>
		</div>
		<div class="col-sm-7">
			<?= $this->Flash->render() ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div class="col-sm-2 well">
			<!-- お知らせを３つだけ表示する -->
			<?php foreach($side_notifications as $show_side_notifications) :?>
			<div class="thumbnail">
				<span class="label label-danger">お知らせ</span>
				<p><strong><?= $show_side_notifications['Notification']['title'] ?></strong></p>
				<p><?= mb_substr($show_side_notifications['Notification']['content'], 0, 20) ?>..</p>
				<a href="/attendance_system/student/StudentUsers/notification_detail/<?= $show_side_notifications['Notification']['id']?>">詳細</a>
			</div>
			<?php endforeach ?>
			<a href="/attendance_system/student/StudentUsers/notification" class="btn btn-primary">もっと見る</a>
		</div>
	</div>
</div>

<!-- パスワードを変えるmodal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<p>パスワードを変えます</p>
			<?= $this->Form->create('StudentUser', ['url' => 'edit'])?>
				<?= $this->Form->input('current_password', ['type' => 'password', 'label' => false, 'placeholder' => '現在のパスワード', 'required'])?>
				<?= $this->Form->input('new_password', ['type' => 'password', 'label' => false, 'placeholder' => '新しいパスワード', 'required'])?>
				<button type="submit" class="btn btn-success">登録</button>
			<?= $this->Form->end()?>
		</div>
	</div>
</div>

<footer class="container-fluid text-center">
	<p>Footer Text</p>
</footer>
</body>
</html>