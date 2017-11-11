<!-- 管理者追加 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>管理者追加</strong></div>
        <div class="panel-body">  
          <?= $this->Form->create('User',['url' => 'register/member_add'])?>
          <div class="form-group">
            <label for="name">管理者名</label>
            <?= $this->Form->input('name',['label' => false,'class' => 'form-control']) ?>
          </div>
          <div class="form-group">
            <label for="email">メールアドレス</label>
            <?= $this->Form->input('email',['label' => false,'class' => 'form-control','placeholder'=>'メールアドレスを入力してください']) ?>
          </div>
          <button type="submit" class="btn btn-primary">管理者追加</button>
          <?= $this->Form->end() ?>
        </div>
    </div>
  </div>
</div>

<!-- 管理者一覧 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        管理者一覧
      </div>
      <div class="panel-body">
        <a href="edit" class="btn btn-info btn-sm">登録情報・パスワード変更</a><br><br>
        <table class="table table-default" border="1">
          <thead>
            <tr>
              <th>#</th>
              <th>名</th>
            </tr>
          </thead>
          <tbody>
          <!-- admin = 1  -->
            <?php foreach($admin_users as $key => $members) : ?>
            <tr>
              <th><?= ($key +=1) ?></th>
              <td><?= $members['User']['name']?>
                <a href="delete/<?= $members['User']['id'] ?>" class="label label-danger"　onclick="return confirm('メンバーを削除します、よろしいですか？');">削除</a>
              </td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>