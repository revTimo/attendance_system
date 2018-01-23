<div class="row">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">出席一覧</h3><br><br>
        <span><i class="fa fa-check" aria-hidden="true"></i>出席</span>
        <span><i class="fa fa-times" aria-hidden="true"></i>欠席</span>
        <span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>遅刻</span>
      </div>
      <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>教室名</th>
                <th>学生名</th>
                <th>status</th>
                <th>IPアドレス</th>
                <th>授業開始時間</th>
                <th>出席した時間</th>
                <th>日付</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($attendance_list as $lists) : ?>
                <tr>
                  <td><?= $lists['class_name']['ClassRoom']['name'] ?></td>
                  <td><?= $lists['student_name']['Student']['name'] ?></td>
                  <?php if ($lists['status'] == 0) :?>
                  <td><span><i class="fa fa-times" aria-hidden="true"></i></span></td>
                  <?php endif ?>
                  <?php if ($lists['status'] == 1) :?>
                  <td><span><i class="fa fa-check" aria-hidden="true"></i></span></td>
                  <?php endif ?>
                  <?php if ($lists['status'] == 2) :?>
                  <td><span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span></td>
                  <?php endif ?>
                  <td><?= $lists['ip_address'] ?></td>
                  <td><?= $lists['class_start_at'] ?></td>
                  <td><?= $lists['student_attend_at'] ?></td>
                  <td><?= $lists['created'] ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>