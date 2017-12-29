<div class="container">
  <div class="row vertical-offset-100">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">アカウント発行</h3>
        </div>
        <!-- ここにメッセージなどを表示 -->
        <p class="login-box-msg"><?php echo $this->Flash->render(); ?></p>
        <div class="panel-body">
          <?= $this->Form->create('StudentUsers') ?>
            <fieldset>
              <div class="form-group">
                <?= $this->Form->input('student_number', ['label' =>false, 'class' => 'form-control', 'placeholder' => '学生番号', 'required']) ?>
              </div>
              <label>
                <a href="login">ログイン画面へ</a>
              </label>
              <input class="btn btn-lg btn-success btn-block" type="submit" value="登録">
            </fieldset>
          <?= $this->Form->end() ?>
        </div>
      </div>
    </div>
  </div>
</div>