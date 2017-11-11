<?php foreach($major_subjects as $data) : ?>
<div class="container">
  <h2>確認画面</h2>
  <?= $this->Form->create('Subject',['url' => 'add_subject']) ?>
    <div class="form-group">
      <label class="col-sm-2">専攻名:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="data[Subject][major_name]" value="<?= $data['major_name']?>">
        <!-- <?= $this->Form->input('major_name',['label' => false, 'class' => 'form-control', 'value' => $data['major_name']]) ?> -->
      </div>
    </div>
    <?php foreach($data['subjects'] as $all_subjects) : ?>
    <div class="form-group">
      <label class="col-sm-2">科目:</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" name="data[Subject][subjects][]" value="<?=$all_subjects?>">
        <!-- <?= $this->Form->input('subjects.0',['label' => false, 'class' => 'form-control', 'value' => $all_subjects]) ?> -->
      </div>
    </div>
  <?php endforeach ?>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      　　<a href="index" class="btn btn-warning" role="button">戻る</a>
        <button type="submit" class="btn btn-default">登録</button>
      </div>
    </div>
  <?= $this->Form->end() ?>
</div>
<?php endforeach ?>
