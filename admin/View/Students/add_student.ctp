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
              'options' => ['0' => '専攻を選択してください',$all_major],
              'selected' => '0',
              ]);
            ?>
          </div>
          <br>
          <div class="form-group">
            <label for="email">学生メールアドレス</label>
            <?= $this->Form->input('email',['label' => false,'class' => 'form-control','placeholder'=>'メールアドレスを入力してください']) ?>
          </div>
          <div>
            <label>住所</label>
            <?= $this->Form->input('address',['label' => false,'class' => 'form-control']) ?>
          </div>
          <br>
          <a class="btn btn-primary btn-xs" id="image_add">画像を追加する</a>
          <div class="form-group profile_img">
            <!-- 画像アップロード -->
            <div class="error-message"></div>
          </div>
          <button type="submit" class="btn btn-primary">登録する</button>
          <?= $this->Form->end() ?>
        </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $("#image_add").click(function(){
      $(".profile_img").append('<div class="img_upload"><label for="image">写真</label><?= $this->Form->input("Student.image",["label" => false, "type" => "file", "id" => "student_img", "required"])?><button type="button" class="btn btn-danger btn-xs" onclick="remove(this)">削除</button></div>');
      $("#image_add").css("display", "none");
    });
  });

  function remove (target) {
    $(target).parent('.img_upload').empty();
    $("#image_add").css("display", "inline-block");
  }

  $('form').on('change', 'input[type="file"]', function() {
    $(".error-message").text('');
    if(this.files[0].type != 'image/jpeg' && this.files[0].type != 'image/png')
    {
      $(".error-message").text('画像ファイル以外アップロードできません。有効な画像ファイルを指定してください。');
      $(this).val("");
    }
    if(this.files[0].size/1024/1024 >= 1.2)
    {
      $(".error-message").text('ファイルアップロードできませんでした。画像は 1MB 未満でなければなりません。');
      $(this).val("");
    }
  });
</script>