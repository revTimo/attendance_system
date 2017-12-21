<!-- 学生編集 -->
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-heading"><strong>学生情報編集</strong></div>
        <div class="panel-body">  
          <?= $this->Form->create('Student',['enctype' => 'multipart/form-data', 'url' => 'add_student/28/'.$edit_student['Student']['id']])?>
          <div class="form-group">
            <label for="name">学生名</label>
            <?= $this->Form->input('name',['label' => false,'class' => 'form-control', 'value' => $edit_student['Student']['name']]) ?>
          </div>
          <div class="form-group">
            <label for="name">学生番号</label>
            <?= $this->Form->input('student_number',['label' => false,'class' => 'form-control', 'value' => $edit_student['Student']['student_number']]) ?>
          </div>
          <div class="form-group">
            <label for="name">学年</label>
            <?= $this->Form->input('grade',['label' => false,'class' => 'form-control', 'min' => '1', 'value' => $edit_student['Student']['grade']]) ?>
          </div>
          <div class="form-group">
            <label for="name">学科選択</label>
            <?= $this->Form->input('subject_id', [
              'label' => false,
              'class' => 'select2 col-md-12',
              'name' => 'data[Student][major_id]',
              'options' => ['no_major_id'=>'未登録',$all_major],
              'selected' => $edit_student['Student']['major_id'],
              ]);
            ?>
          </div>
          <br>
          <div class="form-group">
            <label for="email">学生メールアドレス</label>
            <?= $this->Form->input('email',['label' => false,'class' => 'form-control','placeholder'=>'メールアドレスを入力してください', 'value' => $edit_student['Student']['email']]) ?>
          </div>
          <div class="form-group">
            <label for="address">住所</label>
            <?= $this->Form->input('address',['label' => false,'class' => 'form-control','value' => $edit_student['Student']['address']]) ?>
          </div>
          <div class="form-group profile_img">
            <!-- 画像アップロード -->
            <?=$this->Html->image('../student_image/'.$edit_student['Student']['image'],['class'=>'img-thumbnail', 'alt' => 'student_profile_img', 'width' => '200', 'height' => '200'])?>
            <?=$this->Form->input('current_img',['type' => 'hidden', 'value' => $edit_student['Student']['image']]) ?>
          </div>
          <a class="btn btn-primary btn-xs" id="image_add">プロフィル写真を変える</a><br><br>
          <a href="../" class="btn btn-warning">一覧へ戻る</a>
          <button type="submit" class="btn btn-primary">編集する</button>
          <?= $this->Form->end() ?>
        </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function(){
    $("#image_add").click(function(){
      $(".profile_img").append('<div class="img_upload"><label for="image">写真</label><?= $this->Form->input("Student.image",["label" => false, "type"=>"file"])?><button type="button" class="btn btn-danger btn-xs" onclick="remove(this)">削除</button></div>');
      $("#image_add").css("display", "none");
    });
  });

  function remove (target) {
    $(target).parent('.img_upload').remove();
    $("#image_add").css("display", "inline-block");
  }
</script>