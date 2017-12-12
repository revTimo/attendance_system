<!-- 管理者追加 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>管理者追加</strong></div>
        <div class="panel-body">  
          <?= $this->Form->create('User',['url' => 'add_member'])?>
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
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">管理者・メンバー一覧</h3><br><br>
        <a href="edit" class="btn btn-primary btn-sm">登録情報・パスワード変更</a><br><br>
      </div>
      <div class="box-body">
        <!-- 学生一覧 -->
        <p class="text-red">メンバーstatus更新や削除は管理者のみの権限になっています</p>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>名</th>
                <th>Status</th>
                <?php if($current_user == ADMIN) :?>
                <th>Change Status</th>
                <th>削除</th>
                <?php endif ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($admin_users as $members) : ?>
                <tr>
                  <td><?= $members['User']['name'] ?></td>
                  <?php if($members['User']['is_admin'] == ADMIN) :?>
                  <td>ADMIN</td>
                  <?php elseif($members['User']['is_admin'] == MEMBER):?>
                  <td>MEMBER</td>
                  <?php endif ?>
                  <?php if($current_user == ADMIN) :?>
                  <?php if($members['User']['is_admin'] == ADMIN) :?>
                  <td><a href="/attendance_system/admin/users/change_status/<?= $members['User']['id']?>/retire"　onclick="return confirm('一般メンーバの権限にします。よろしいですか？')">一般メンーバになる</a></td>
                  <?php elseif($members['User']['is_admin'] == MEMBER):?>
                  <td><a href="/attendance_system/admin/users/change_status/<?= $members['User']['id']?>/make_admin" onclick="return confirm('管理者の権限にします。よろしいですか？')">管理者にする</a></td>
                  <?php endif ?>
                  <td>
                    <?php if($members['User']['id'] != $current_user_id):?>
                    <a href="/attendance_system/admin/users/delete/<?= $members['User']['id'] ?>" class="label label-danger" onclick="return confirm('管理者を削除します、よろしいですか？');">削除</a>
                    <?php endif ?>
                  </td>
                  <?php endif ?>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</div>