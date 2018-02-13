<!-- 学科登録 -->
<!-- CK Editor -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>お知らせ登録</strong></div>
			<div class="panel-body">  
				<?= $this->Form->create('Notification',['url' => 'confirm'])?>
				<div class="form-group">
					<label for="name">タイトル</label>
					<?= $this->Form->input('title',['label' => false, 'class' => 'form-control','required']) ?>
				</div>
				<div class="form-group">
					<label for="name">コンテンツ</label>
					<?= $this->Form->input('content', ['type' => 'textarea', 'label' => false, 'class' => 'form-control', 'required', 'rows' => '10', 'cols' => '80', 'id' => 'notification_editor']) ?>
				</div>
				<div class="form-group">
					<label for="name">公開日</label>
					<?= $this->Form->input('publish_at', ['type' => 'text', 'label' => false, 'class' => 'datetimepicker form-control', 'required']) ?>
				</div>
				<button type="submit" class="btn btn-primary">確認画面へ</button>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">お知らせ一覧</h3>
			</div>
			<div class="box-body">
				<form id="multi_delete" method="post" action="/attendance_system/admin/notifications/delete" onsubmit="return confirm('選択されている学生全てが削除されます。よろしいですか');">
					<button type="submit" name="multi_delete_btn" disabled class="btn btn-danger" id="off">選択したお知らせ全てを削除する</button><br><br>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>タイトル</th>
								<th>コンテンツ</th>
								<th>公開日</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_notifications as $notification) : ?>
								<tr>
									<td>
										<input type="checkbox" name="deletedata[]" value="<?= $notification['Notification']['id']?>" class="checkbox"><?= $notification['Notification']['title'] ?>
									</td>
									<td>
										<?= $notification['Notification']['content'] ?>
									</td>
									<td><?= $notification['Notification']['publish_at']?></td>
									<td><a href="/attendance_system/admin/notifications/edit/<?= $notification['Notification']['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
									<td><a href="/attendance_system/admin/notifications/delete/<?= $notification['Notification']['id']?>" onclick="return confirm('学生を削除します、よろしいですか？');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- CK Editor -->
<?= $this->Html->script('../ckeditor/ckeditor.js')?>
<script>
// CK editor
CKEDITOR.replace('notification_editor');
</script>