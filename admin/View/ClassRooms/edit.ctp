<!-- 教室登録確認画面 -->
<div class="col-md-6">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">以下の内容で登録されます</h3>
		</div>
		<div class="box-body">
			<?= $this->Form->create('ClassRoom',['url' => 'add'])?>
				<div class="form-group">
					<label for="name">教室名</label>
					<?= $this->Form->input('name',['label' => false,'class' => 'form-control','required', 'value' => $data['name']]) ?>
				</div>
				<div class="form-group sub">
					<label for="name">科目</label>
					<?= $this->Form->input('subject_id', [
						'label' => false,
						'class' => 'select2 col-md-12',
						'required',
						'options' => ['no_subject_id'=>'専攻を選択してください',$all_subject],
						'selected' => $data['subject_id'],
					])?>
				</div>
				<div class="form-group">
					<label for="name">学年</label>
					<?= $this->Form->input('grade',['label' => false,'class' => 'form-control','value' => $data['grade']]) ?>
				</div>
				<div class="form-inline">
					<label>学期</label><br>
					<div class="input-group">
						<input type="date" name="ClassRoom[semester_from]" class="form-control" value="<?= $data['semester_from']?>">
					</div>
					<span> ~ </span>
					<div class="input-group">
						<input type="date" name="ClassRoom[semester_to]" class="form-control" value="<?= $data['semester_to']?>">
					</div>
				</div>
				<div class="bootstrap-timepicker">
					<div class="form-group">
						<label>授業開始時間:</label>
						<div class="input-group">
							<input type="time" name="ClassRoom[start_time]" class="form-control" value="<?= $data['start_time']?>">
						</div>
					</div>
				</div>
				<div class="bootstrap-timepicker">
					<div class="form-group">
						<label>授業終了時間:</label>
						<div class="input-group">
							<input type="time" name="ClassRoom[end_time]" class="form-control" value="<?= $data['end_time']?>">
						</div>
					</div>
				</div>
			<a href="../class_list" class="btn btn-warning">戻る</a>
			<button type="submit" class="btn btn-primary">登録する</button>
		</div>
	</div>
</div>
<div class="col-md-6">
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">授業を受ける学生</h3>
			<div class="box-tools pull-right">
				<span class="label label-danger ninn"></span>
			</div>
		</div>
		<div class="box-body no-padding">
			<ul class="users-list clearfix atd">
				<?php foreach($student_list as $key => $student) :?>
				<li id="<?= $key?>">
					<img src="../webroot/student_image/<?= $student['img']?>" alt="User Image">
					<a class="users-list-name" href="#"><?=$student['name']?></a>
					<span class="users-list-date"><?=$student['major']['Major']['name']?></span>
					<?= $this->Form->input("ClassRoom.students_id.$key", ['type' => 'hidden', 'value' => $student['id'], 'id' => $student['id']]) ?>
					<a onclick="remove_student(<?=$key?>)">get out</a>
				</li>
				<?php endforeach ?>
			</ul>
			<!-- form 終了タグ -->
			<?= $this->Form->end() ?>
		</div>
	</div>
</div>