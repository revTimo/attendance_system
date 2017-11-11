<div class="panel panel-primary">
  <div class="panel-heading">アカウント編集</div>
  <div class="panel-body">  
    <?= $this->Form->create('User',['url' => 'edit'])?>
    <div class="form-group">
      <label for="name">名前</label>
      <?= $this->Form->input('name',['label' => false,'class' => 'form-control','value' => $edit_data['User']['name']]) ?>
    </div>
    <div class="form-group">
      <label for="email">メールアドレス</label>
      <?= $this->Form->input('email',['label' => false,'class' => 'form-control','value' => $edit_data['User']['email']]) ?>
    </div>
    <div class="form-group">
      <label for="email">以前のパスワード</label>
      <?= $this->Form->input('old_password',['label' => false,'class' => 'form-control','type' => 'password']) ?>
    </div>
    <div class="form-group">
      <label for="email">新しいパスワード</label>
      <?= $this->Form->input('password',['label' => false,'class' => 'form-control','type' => 'password']) ?>
    </div>
    <a href="index" class="btn btn-primary">戻る</a>
    <button type="submit" class="btn btn-primary">編集</button>
    <?= $this->Form->end() ?>
  </div>
</div>