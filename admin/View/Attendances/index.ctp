<div class="col-md-6">
<?php foreach($allAttendance as $key => $showAttendance) :?>
<div class="box">
	<div class="box-header">
		<h3 class="box-title"><?= $showAttendance['subject']['Subject']['name']?>授業</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body no-padding">
		<table class="table table-condensed">
			<tbody>
				<tr>
					<th style="width: 10px">#</th>
					<th>学生名</th>
					<th>出席パーセント</th>
					<th style="width: 40px"></th>
				</tr>
				<?php foreach($showAttendance['student'] as $key => $student) :?>
				<tr>
					<!-- 学生for -->
					<td><?= $key+1 ?></td>
					<td><a href="/attendance_system/admin/attendances/detail/<?= $showAttendance['class_id']?>/<?= $student['id']?>"><?= $student['name']?></a></td>
					<td>
						<div class="progress progress-xs">
							<div class="progress-bar progress-bar-danger" style="width: <?= $showAttendance['attendance_rate'][$key]['attend_percent']?>%"></div>
						</div>
					</td>
					<td><span class="badge bg-red"><?= $showAttendance['attendance_rate'][$key]['attend_percent']?>%</span></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<!-- /.box-body -->
</div>
<?php endforeach ?>
</div>