<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">教室詳細</h3>
    </div>
    <div class="box-body">
      
        <div class="form-group">
          <label for="name">教室名</label>
          <h3><?= $data['name'] ?></h3>
        </div>
        <div class="form-group sub">
          <label for="name">科目</label>
          <p><?= $subject_name?></p>
        </div>
        <div class="form-group">
          <label for="name">学年</label>
          <p><?= $data['grade']?></p>
        </div>
        <div class="form-inline">
          <label>学期</label><br>
          <div class="input-group">
            <p><?= $data['semester_from']?></p>
          </div>
          <span> ~ </span>
          <div class="input-group">
            <p><?= $data['semester_to']?></p>
          </div>
        </div>
        <div class="form-group">
          <label for="name">曜日</label>
          <?php $week = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];?>
          <p><?= $week[$data['week']]?></p>
        </div>
        <div class="bootstrap-timepicker">
          <div class="form-group">
            <label>授業開始時間:</label>
            <div class="input-group">
              <p><?= $data['start_time']?></p>
            </div>
          </div>
        </div>
        <div class="bootstrap-timepicker">
          <div class="form-group">
            <label>授業終了時間:</label>
            <div class="input-group">
              <p><?= $data['end_time']?></p>
            </div>
          </div>
        </div>
      <a href="../class_list" class="btn btn-warning">戻る</a>
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">参加学生</h3>
      <div class="box-tools pull-right">
        <span class="label label-danger ninnn"></span>
      </div>
    </div>
    <div class="box-body no-padding">
      <div class="std_list">
      <ul class="users-list clearfix　atda">
        <?php foreach($student_list as $key => $student) :?>
        <li id="<?= $key?>" class="std">
          <img src="/attendance_system/admin/webroot/student_image/<?= $student['img']?>" alt="User Image">
          <span class="users-list-name"><?=$student['name']?></span>
          <span class="users-list-date"><?=$student['major']['Major']['name']?></span>
        </li>
        <?php endforeach ?>
      </ul>
      </div>
    </div>
  </div>
</div>