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
					<?= $this->Form->input('title',['label' => false, 'class' => 'form-control','required', 'value' => $post_data['Notification']['title']]) ?>
				</div>
				<div class="form-group">
					<label for="name">コンテンツ</label>
					<?= $this->Form->input('content', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'required', $post_data['Notification']['content']]) ?>
				</div>
				<div class="form-group">
					<label for="name">公開日</label>
					<?= $this->Form->input('publish_at', ['type' => 'text', 'label' => false, 'class' => 'datetimepicker form-control', 'required', 'value' => $post_data['Notification']['publish_at']]) ?>
				</div>
				<button type="submit" class="btn btn-primary">登録する</button>
				<button type="submit" class="btn btn-warning">戻る</button>
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>
