<!DOCTYPE html>
<html lang="jp">
<head>
  <title>出席管理システム</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
  </style>
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
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Messages</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
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
        <p>科目</p>
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
      <p><a href="#">タイムライン</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
    <div class="col-sm-7">
      <?= $this->Flash->render() ?>
      <?php echo $this->fetch('content'); ?>
    </div>
    <div class="col-sm-2 well">
      <div class="thumbnail">
        <p>お知らせ</p>
        <p><strong>Paris</strong></p>
        <p>Fri. 27 November 2015sssss</p>
        <button class="btn btn-primary">詳細</button>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
