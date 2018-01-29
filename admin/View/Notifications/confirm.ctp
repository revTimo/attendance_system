<h3>お知らせ確認画面</h3>
<div class="col-md-12">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">以下の内容でお知らせが登録されます</h3>
		</div>
		<div class="box-body padding">
			<?= $this->Form->create('Notification',['url' => 'add'])?>
				<div class="form-group">
					<label for="name">タイトル</label>
					<p><?= $post_data['Notification']['title'] ?></p>
					<?= $this->Form->input('title',['type' => 'hidden', 'label' => false, 'class' => 'form-control','required', 'value' => $post_data['Notification']['title']]) ?>
				</div>
				<div class="form-group">
					<label for="name">コンテンツ</label>
					<p><?= $post_data['Notification']['content'] ?></p>
					<?= $this->Form->input('content', ['type' => 'hidden', 'label' => false, 'class' => 'form-control', 'required', 'value' => $post_data['Notification']['content']]) ?>
				</div>
				<div class="form-group">
					<label for="name">公開日</label>
					<p><?= $post_data['Notification']['publish_at'] ?></p>
					<?= $this->Form->input('publish_at', ['type' => 'hidden', 'label' => false, 'class' => 'form-control', 'required', 'value' => $post_data['Notification']['publish_at']]) ?>
				</div>
				<button type="submit" class="btn btn-primary">登録する</button>
				<a href="/attendance_system/admin/notifications/index" class="btn btn-warning">戻る</a>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
