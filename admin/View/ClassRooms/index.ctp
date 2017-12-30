<!-- 教室登録 -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>教室登録</strong></div>
			<div class="panel-body">  
				<?= $this->Form->create('ClassRoom',['url' => 'confirm'])?>
				<div class="form-group">
					<label for="name">教室名</label>
					<?= $this->Form->input('name',['label' => false,'class' => 'form-control','required']) ?>
				</div>
				<div class="form-group sub">
					<label for="name">科目</label>
					<?= $this->Form->input('subject_id', [
						'label' => false,
						'class' => 'select2 col-md-12',
						'options' => ['no_subject_id'=>'専攻を選択してください',$all_subject],
					])?>
				</div>
				<div class="form-group">
					<label for="name">学年</label>
					<?= $this->Form->input('grade',['label' => false,'class' => 'form-control','required', 'max' => '5', 'min' => '1']) ?>
				</div>
				<div class="form-inline">
					<label>学期from</label><br>
					<div class="input-group col-xs-2">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" name="ClassRoom[semester_from]" class="form-control">
					</div>
					<span>to</span>
					<div class="input-group col-xs-2">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" name="ClassRoom[semester_to]" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label for="name">曜日</label>
					<?= $this->Form->input('week', [
						'label' => false,
						'class' => 'select2 col-md-12',
						'options' => ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
					])?>
				</div>
				<div class="bootstrap-timepicker">
					<div class="form-group">
						<label>授業開始時間:</label>
						<div class="input-group col-xs-2">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							<input type="time" name="ClassRoom[start_time]" class="form-control">
						</div>
					</div>
				</div>
				<div class="bootstrap-timepicker">
					<div class="form-group">
						<label>授業終了時間:</label>
						<div class="input-group col-xs-2">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							<input type="time" name="ClassRoom[end_time]" class="form-control">
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary">確認画面へ</button>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>