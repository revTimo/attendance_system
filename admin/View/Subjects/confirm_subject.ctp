<?php foreach($major_subjects as $data) : ?>
<div class="container">
  <h2>確認画面</h2>
  <?= $this->Form->create('Subject', ['url' => 'add_subject']) ?>
    <div class="form-group">
      <label class="col-sm-2">専攻名:</label>
      <div class="col-sm-9">
        <?= $this->Form->input('major_name',['label' => false, 'class' => 'form-control', 'value' => $data['major_name']]) ?>
      </div>
    </div>
    <?php if(!empty($data['subjects'])) :?>
      <?php foreach($data['subjects'] as $key => $all_subjects) : ?>
        <div class="form-group">
          <label class="col-sm-2">科目:</label>
          <div class="col-sm-9">
            <?= $this->Form->input("Subject.subjects.$key",['label' => false, 'class' => 'form-control', 'value' => $all_subjects]) ?>
          </div>
        </div>
      <?php endforeach ?>
    <?php endif ?>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      　　<a href="index" class="btn btn-warning" role="button">戻る</a>
        <button type="submit" class="btn btn-default">登録</button>
      </div>
    </div>
  <?= $this->Form->end() ?>
</div>
<?php endforeach ?>