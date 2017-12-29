<div class="container">
  <div class="row vertical-offset-100">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">ログイン</h3>
        </div>
        <!-- ここにメッセージなどを表示 -->
        <p class="login-box-msg"><?php echo $this->Flash->render(); ?></p>
        <div class="panel-body">
          <?= $this->Form->create('StudentUser') ?>
            <fieldset>
              <div class="form-group">
                <?= $this->Form->input('student_number', ['label' =>false, 'class' => 'form-control', 'placeholder' => '学生番号', 'required']) ?>
              </div>
              <div class="form-group">
                <?= $this->Form->input('password', ['label' =>false, 'class' => 'form-control', 'placeholder' => 'パスワード', 'required']) ?>
              </div>
              <label>
                <a href="/attendance_system/student/student_users/register">初めて</a>
              </label>
              <input class="btn btn-lg btn-success btn-block" type="submit" value="ログイン">
            </fieldset>
          <?= $this->Form->end() ?>
        </div>
      </div>
    </div>
  </div>
</div>