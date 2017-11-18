<!-- 学生登録 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>学生登録</strong></div>
        <div class="panel-body">  
          <?= $this->Form->create('Student',['enctype' => 'multipart/form-data', 'url' => 'add_student'])?>
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
            <?= $this->Form->input('grade',['label' => false,'class' => 'form-control', 'min' => '1']) ?>
          </div>
          <div class="form-group">
            <label for="name">学科選択</label>
            <?= $this->Form->input('subject_id', [
              'label' => false,
              'class' => 'select2 col-md-12',
              'name' => 'data[Student][major_id]',
              'options' => ['no_major_id'=>'なし',$all_major],
              'selected' => 'no_major_id',
              ]);
            ?>
          </div>
          <br>
          <div class="form-group">
            <label for="email">学生メールアドレス</label>
            <?= $this->Form->input('email',['label' => false,'class' => 'form-control','placeholder'=>'メールアドレスを入力してください']) ?>
          </div>
          <!-- <div class="form-group">
            <label for="image">写真</label>
            <?= $this->Form->input('image',['label'=>false,'type'=>'file']) ?>
          </div> -->
          <button type="submit" class="btn btn-primary">確認画面へ</button>
          <?= $this->Form->end() ?>
        </div>
    </div>
  </div>
</div>