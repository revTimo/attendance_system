<h2>編集画面</h2>
<div class="col-md-12">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">以下の内容でお知らせが登録されます</h3>
		</div>
		<div class="box-body padding">
			<?= $this->Form->create('Notification',['url' => 'add/'. $edit_notification['Notification']['id'] .'/28'])?>
				<div class="form-group">
					<label for="name">タイトル</label>
					<?= $this->Form->input('title',['label' => false, 'class' => 'form-control','required', 'value' => $edit_notification['Notification']['title']]) ?>
				</div>
				<div class="form-group">
					<label for="name">コンテンツ</label>
					<?= $this->Form->input('content', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'required', 'value' => $edit_notification['Notification']['content']]) ?>
				</div>
				<div class="form-group">
					<label for="name">公開日</label>
					<?= $this->Form->input('publish_at', ['type' => 'text', 'label' => false, 'class' => 'datetimepicker form-control', 'required', 'value' => $edit_notification['Notification']['publish_at']]) ?>
				</div>
				<button type="submit" class="btn btn-primary">登録する</button>
				<a href="/attendance_system/admin/notifications/index" class="btn btn-warning">戻る</a>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>