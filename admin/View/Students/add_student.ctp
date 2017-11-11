<!-- 学生登録 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>学生登録</strong></div>
        <div class="panel-body">  
          <?= $this->Form->create('User',['url' => 'register/member_add'])?>
          <div class="form-group">
            <label for="name">学生名</label>
            <?= $this->Form->input('name',['label' => false,'class' => 'form-control']) ?>
          </div>
          <div class="form-group">
            <label for="name">学生番号</label>
            <?= $this->Form->input('student_number',['label' => false,'class' => 'form-control']) ?>
          </div>
          <div class="form-group">
            <label for="name">学年</label>
            <?= $this->Form->input('grade',['label' => false,'class' => 'form-control']) ?>
          </div>
          <div class="form-group">
            <label for="name">学科選択</label>
            <?= $this->Form->input('subject_id', [
              'label' => false,
              'class' => 'select2 col-md-12',
              //'name' => 'data[Instagram][item_id][]',
              //'options' => ['no_item'=>'なし',$items_data],
              'selected' => 'no_item',
              ]);
            ?>
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