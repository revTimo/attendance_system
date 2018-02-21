<div class="col-md-12">
  <!-- Profile Image -->
  <div class="box box-primary">
    <div class="box-body box-profile">
      <?=$this->Html->image('../student_image/'.$edit_student['Student']['image'],['class'=>'img-thumbnail', 'alt' => 'student_profile_img', 'width' => '200', 'height' => '200'])?>
      <h3 class="profile-username text-center"><?= $edit_student['Student']['name'] ?></h3>
      <p class="text-muted text-center"><?= $edit_student['Student']['student_number'] ?></p>
      <ul class="list-group list-group-unbordered">
        <li class="list-group-item">
          <i class="fa fa-line-chart margin-r-5"></i><b>出席率</b> <a class="pull-right">80%</a>
        </li>
        <li class="list-group-item">
          <b>成績</b> <a class="pull-right">B</a>
        </li>
        <li class="list-group-item">
          <b>評価</b> <a class="pull-right">B</a>
        </li>
      </ul>
      <!-- <a href="#" class="btn btn-danger btn-block"><b>連絡!</b></a> -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  <!-- About Me Box -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">学科・専攻など</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <strong><i class="fa fa-book margin-r-5"></i> 専攻</strong>
      <p class="text-muted">
        <?php if(!empty($major)):?>
        <?= $major['Major']['name']?>
        <?php else:?>
        <span>未登録</span>
        <?php endif?>
      </p>
      <hr>
      <strong><i class="fa fa-pencil margin-r-5"></i> 科目</strong>
      <p>
        <?php if(!empty($major)):?>
        <?php
            $style = [
              'danger',
              'success',
              'info',
              'warning',
              'primary',
            ];
          ?>
        <?php foreach ($major['Subject'] as $sub) :?>
          <?= '<span class="label label-'.$style[rand(0,4)].'">'.$sub['name'].'</span>'?>
        <?php endforeach ?>
        <?php else:?>
          <span>未登録</span>
        <?php endif ?>
      </p>
      <hr>
      <strong><i class="fa fa-map-marker margin-r-5"></i> 住所</strong>
      <p class="text-muted"><?= $edit_student['Student']['address'] ?></p>
      <hr>
      <strong><i class="fa fa-envelope-o margin-r-5"></i> 連絡先</strong>
      <p><?= $edit_student['Student']['email'] ?></p>
      <hr>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>