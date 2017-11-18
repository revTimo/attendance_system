<div class="container">
  <h2>編集画面</h2>
  <?= $this->Form->create('Subject',['url' => 'edit/'.$edit_subject['Major']['id']]) ?>
    <div class="form-group">
      <label class="col-sm-2">専攻名:</label>
      <div class="col-sm-9">
        <?= $this->Form->input('Subject.major_name',['label' => false, 'class' => 'form-control', 'value' =>  $edit_subject['Major']['name']]) ?>
      </div>
    </div>
    <?php foreach($edit_subject['Subject'] as $key => $all_subjects) : ?>
    <div class="form-group sub">
      <label class="col-sm-2">科目:</label>
      <div class="col-sm-9">
        <?= $this->Form->input("Subject.subjects.$key.id",['label' => false, 'class' => 'form-control', 'value' => $all_subjects['id']]) ?>
        <?= $this->Form->input("Subject.subjects.$key.name",['label' => false, 'class' => 'form-control', 'value' => $all_subjects['name']]) ?>
        <button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this, <?=$all_subjects['id']?>)">削除</button>
      </div>
    </div>
    <?php endforeach ?>
    <span class="clone"></span>
    <button type="button" class="btn btn-primary btn-xs" id="subject_add">新しい科目を追加</button><br><br>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      　　<a href="index" class="btn btn-warning" role="button">戻る</a>
        <button type="submit" class="btn btn-default">編集</button>
      </div>
    </div>
  <?= $this->Form->end() ?>
</div>

<script>
  $(document).ready(function(){
    var subject_clone_count = 1;
    $("#subject_add").click(function(){
      $(".clone").append('<div class="form-group sub"><label class ="col-sm-2" for="name">科目</label><div class="col-sm-9"><?= $this->Form->input("Subject.new_subjects.'+subject_clone_count+'",["label" => false,"class" => "form-control sub_clone","required"]) ?><button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this)">削除</button></div></div><br>');
      subject_clone_count++;
    });
  });

  function remove_item(target, $id) {
    if (confirm('登録されている科目がDBから削除されます、よろしいですか？') == false)
    {
      return;
    }
    $(target).parents('.sub').remove();
    $.ajax({
      url : "/attendance_system/admin/subjects/delete_edit",
      type : "POST",
      data : {id : $id},
      dataType : "text",
      success : function (response) {
        //通信成功時の処理
      },
      error : function () {
        //通信失敗
        alert('ajax 通信失敗しました');
      }
    });
  }
</script>