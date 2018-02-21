<?php $week = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'];?>
<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title"><?= $allAttendance['subject']['Subject']['name']?>授業
					<span><?= $week[$allAttendance['week']]?></span></h3>
				<h4><?= $allAttendance['semester_from'].'~'.$allAttendance['semester_to'] ?> 出席</h4><br><br>
				<span><i class="fa fa-check" aria-hidden="true"></i>出席</span>
				<span><i class="fa fa-times" aria-hidden="true"></i>欠席</span>
				<span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>遅刻</span>
			</div>
			<div class="box-body">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>日付</th>
							<?php foreach($allAttendance['student'] as $student) :?>
							<th><?= $student['name']?></th>
							<?php endforeach ?>
						</tr>
					</thead>
					<tbody>
						<?php foreach($allAttendance['date'] as $semester_date) :?>
							<tr>
								<td><?= $semester_date['day'] ?></td>

								<?php if(empty($studentAttend)) :?>
									<?php foreach($allAttendance['student'] as $student) :?>
										<td></td>
									<?php endforeach ?>
								<?php endif ?>
								<?php foreach($studentAttend as $show_status) :?>
									<?php if($semester_date == $show_status['date']) :?>
										<?php foreach($allAttendance['student'] as $student) :?>
												<?php if ($show_status['status'] == 0) :?>
													<td><span><i class="fa fa-times" aria-hidden="true"></i></span></td>
												<?php endif ?>
												<?php if ($show_status['status'] == 1) :?>
													<td><span><i class="fa fa-check" aria-hidden="true"></i></span></td>
												<?php endif ?>
												<?php if ($show_status['status'] == 2) :?>
													<td><span><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span></td>
												<?php endif ?>
										<?php endforeach ?>
									<?php endif ?>
								<?php endforeach ?>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<a href="/attendance_system/admin/attendances/index" class="btn btn-primary">戻る</a>