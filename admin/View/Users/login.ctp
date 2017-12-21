<div class="login-box">
  <div class="login-logo">
    <a href=""><b>出席管理</b>システム</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <!-- ここにメッセージなどを表示 -->
    <p class="login-box-msg"><?php echo $this->Flash->render(); ?></p>

    <?= $this->Form->create('User') ?>
      <div class="form-group has-feedback">
        <?= $this->Form->input('email', ['label' =>false, 'class' => 'form-control', 'placeholder' => 'メールアドレス']) ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <?= $this->Form->input('password', ['label' => false, 'class' => 'form-control', 'placeholder' => 'パスワード']) ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
        </div>
        <!-- /.col -->
      </div>
    <?= $this->Form->end() ?>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
    <!-- /.social-auth-links -->

    <!-- <a href="forgot_password">パスワードを忘れた</a><br> -->
    <a href="register" class="text-center">新規登録</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->