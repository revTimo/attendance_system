<div class="alert alert-info">
  <strong>よこそ!</strong> 出席管理システムにご興味をお持ちいただき、ありがとうございます。ゲストユーザでログイン可能です。
  【メールアドレス：guest@mail.com
  パスワード：guest123】
</div>
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
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">ログイン</button>
        </div>
      </div>
    <?= $this->Form->end() ?>
    <!-- <a href="forgot_password">パスワードを忘れた</a><br> -->
    <a href="register" class="text-center">新規登録</a>
  </div>
</div>