<div class="login-box">
  <div class="login-logo">
    <a href=""><b>管理者</b>登録</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- ここにメッセージなどを表示 -->
    <p class="login-box-msg"><?= $this->Flash->render() ?></p>
    <?= $this->Form->create('User') ?>
      <div class="form-group has-feedback">
        <?= $this->Form->input('email', ['label' =>false, 'class' => 'form-control', 'placeholder' => 'メールアドレス']) ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?= $this->Form->input('user_name', ['label' =>false, 'class' => 'form-control', 'placeholder' => '名前']) ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?= $this->Form->input('school_name', ['label' =>false, 'class' => 'form-control', 'placeholder' => '学校名']) ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?= $this->Form->input('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'パスワード']) ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">登録</button>
        </div>
      </div>
    <?= $this->Form->end() ?>
    <a href="login">ログイン画面へ</a><br>
  </div>
</div>