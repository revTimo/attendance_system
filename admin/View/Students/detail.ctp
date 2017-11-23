<!-- <?= pr($major)?> -->
<div class="col-md-12">
  <!-- Profile Image -->
  <div class="box box-primary">
    <div class="box-body box-profile">
      <?=$this->Html->image('../student_image/'.$edit_student['Student']['image'],['class'=>'img-thumbnail', 'alt' => 'student_profile_img', 'width' => '200', 'height' => '200'])?>
      <h3 class="profile-username text-center"><?= $edit_student['Student']['name'] ?></h3>
      <p class="text-muted text-center"><?= $edit_student['Student']['student_number'] ?></p>
      <ul class="list-group list-group-unbordered">
        <li class="list-group-item">
          <b>Followers</b> <a class="pull-right">1,322</a>
        </li>
        <li class="list-group-item">
          <b>Following</b> <a class="pull-right">543</a>
        </li>
        <li class="list-group-item">
          <b>Friends</b> <a class="pull-right">13,287</a>
        </li>
      </ul>
      <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
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
        <?= $major['Major']['name']?>
      </p>
      <hr>
      <strong><i class="fa fa-pencil margin-r-5"></i> 科目</strong>
      <p>
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
      </p>
      <hr>
      <strong><i class="fa fa-map-marker margin-r-5"></i> 住所</strong>
      <p class="text-muted">Malibu, California</p>
      <hr>
      <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>