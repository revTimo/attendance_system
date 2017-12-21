<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">教室一覧</h3>
			</div>
			<div class="box-body">
				<form id="multi_delete" method="post" action="/attendance_system/admin/class_rooms/delete" onsubmit="return confirm('選択されている学生全てが削除されます。よろしいですか');">
					<button type="submit" name="multi_delete_btn" disabled class="btn btn-danger" id="off">選択した学生全てを削除する</button><br><br>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>教室名</th>
								<th>科目</th>
								<th>学年</th>
								<th>学期</th>
								<th>詳細</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($class_list as $class) : ?>
								<tr>
									<td>
										<input type="checkbox" name="deletedata[]" value="<?= $class['ClassRoom']['id']?>" class="checkbox">
										<?= $class['ClassRoom']['name'] ?>
									</td>
									<td>
										<?php
											for($i=0;$i<count($class);$i++)
											{
												echo $subject_list[$class['ClassRoom']['subject_id']];
											}
										?>
									</td>
									<td><?= $class['ClassRoom']['grade']?></td>
									<td><?= $class['ClassRoom']['semester_from']." ~ ".$class['ClassRoom']['semester_to']?></td>
									<!--  -->
									<td><a href="/attendance_system/admin/class_rooms/detail/<?= $class['ClassRoom']['id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
									<td><a href="/attendance_system/admin/class_rooms/edit/<?= $class['ClassRoom']['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
									<td><a href="/attendance_system/admin/class_rooms/delete/<?= $class['ClassRoom']['id']?>" onclick="return confirm('学生を削除します、よろしいですか？');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>