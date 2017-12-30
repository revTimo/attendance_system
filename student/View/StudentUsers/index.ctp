<div>
<h3><?= $student_info['school_name']?></h3>
<p><?= $student_info['name'] ?>さんよこそ</p>
<a href="#" data-toggle="modal" data-target="#login-modal">パスワードを変える</a>
</div>

<!-- パスワードを変えるmodal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<p>パスワードを変えます</p>
			<?= $this->Form->create('StudentUser', ['url' => 'edit'])?>
				<?= $this->Form->input('current_password', ['type' => 'password', 'label' => false, 'placeholder' => '現在のパスワード', 'required'])?>
				<?= $this->Form->input('new_password', ['type' => 'password', 'label' => false, 'placeholder' => '新しいパスワード', 'required'])?>
				<input type="submit" name="login" class="login loginmodal-submit" value="登録">
			<?= $this->Form->end()?>
		</div>
	</div>
</div>

<!-- 時計と出席授業 -->
<div class="panel panel-primary">
  <div class="panel-heading"><div id="clock" class="clock">読み込み中 ...</div></div>
  <div class="panel-body">
    <?php foreach($all_class as $class) :?>
    <div class="thumbnail col-sm-6">
      <h3><?= $class['name']?>教室</h3>
      <h4><?= $class['subject']['Subject']['name']?>授業</h4>
      <p>授業開始時間: <?= $class['start_time']?></p>
      <button>出席</button>
    </div>
  <?php endforeach ?>
  </div>
</div>

<!-- 時間割 -->
<div class="table-responsive-sm">
  <table class="table">
    <caption>時間割</caption>
    <thead>
      <tr>
        <th>日曜日</th>
        <th>月曜日</th>
        <th>火曜日</th>
        <th>水曜日</th>
        <th>木曜日</th>
        <th>金曜日</th>
        <th>土曜日</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <div class="thumbnail">
            <span data-toggle="popover" title="授業の詳細" data-content="<?= '201教室 Java 14:00'?>">Java</span>
          </div>
          <div class="thumbnail">
            <span>php</span>
          </div>
        </td>
        <td>
          <div class="thumbnail">
            <span>Ruby</span>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  $('[data-toggle="popover"]').popover();
</script>