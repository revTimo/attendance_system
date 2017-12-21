<!-- 学科登録 -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>学科登録</strong></div>
			<div class="panel-body">  
				<?= $this->Form->create('Subject',['url' => 'confirm_subject'])?>
				<div class="form-group">
					<label for="name">専攻名</label>
					<?= $this->Form->input('major_name',['label' => false,'class' => 'form-control','required']) ?>
				</div>
				<div class="form-group sub">
					<label for="name">科目</label>
					<?= $this->Form->input('Subject.subjects.0',['label' => false,'class' => 'form-control sub_clone','id' => 'myid']) ?>
					<button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this)">削除</button> 
				</div>
				<span class="clone"></span>
				<button type="button" class="btn btn-primary btn-xs" id="subject_add">追加</button><br><br>
				<button type="submit" class="btn btn-primary">確認画面へ</button>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>

<!-- 一覧 -->
<div class="box">
	<div class="box-header">
		<h3 class="box-title">学科一覧</h3>
	</div>
	<div class="box-body">
		<form id="multi_delete" method="post" action="/attendance_system/admin/subjects/delete" onsubmit="return confirm('選択されている全ての専攻と科目が削除されます。よろしいですか');">
			<button type="submit" name="multi_delete_btn" disabled class="btn btn-danger" id="off">選択した専攻を削除する</button><br><br>
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>専攻</th>
						<th>科目</th>
						<th>編集</th>
						<th>削除</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($majors_subjects as $data) : ?>
						<tr>
							<td><input type="checkbox" name="deletedata[]" value="<?= $data['Major']['id']?>" class="checkbox"><?= $data['Major']['name'] ?></td>
							<td>
								<?php
									$style = [
										'danger',
										'success',
										'info',
										'warning',
										'primary',
									];
								?>
								<?php foreach($data['Subject'] as $sub) :?>
									<?= '<span class="label label-'.$style[rand(0,4)].'">'.$sub['name'].'</span>'?>
								<?php endforeach ?>		
							</td>
							<td><a href="/attendance_system/admin/subjects/edit/<?= $data['Major']['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
							<td><a href="/attendance_system/admin/subjects/delete/<?= $data['Major']['id']?>" onclick="return confirm('専攻と科目を削除します、よろしいですか？');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</form>
	</div>
</div>


<script>
	//科目を追加
	$(document).ready(function(){
		var subject_clone_count = 1;
		$("#subject_add").click(function(){
			$(".clone").append('<div class="form-group sub"><label for="name">科目</label><?= $this->Form->input("Subject.subjects.'+subject_clone_count+'",["label" => false,"class" => "form-control sub_clone"]) ?><button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this)">削除</button></div><br>');
			subject_clone_count++;
		});
	});
	//追加したのを削除
	function remove_item(target) {
		$(target).parents('.sub').remove();
	}
</script>