<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h3 class="box-title">学生一覧</h3>
			</div>
			<div class="box-body">
				<!-- 学生一覧 -->
				<form id="multi_delete" method="post" action="/attendance_system/admin/students/delete" onsubmit="return confirm('選択されている学生全てが削除されます。よろしいですか');">
					<button type="submit" name="multi_delete_btn" disabled class="btn btn-danger" id="off">選択した学生全てを削除する</button><br><br>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>学生名</th>
								<th>学生番号</th>
								<th>学年</th>
								<th>専攻名</th>
								<th>学生の詳細</th>
								<th>編集</th>
								<th>削除</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($all_student as $data) : ?>
								<tr>
									<td>
										<input type="checkbox" name="deletedata[]" value="<?= $data['Student']['id']?>" class="checkbox">
										<?= $data['Student']['name'] ?>
									</td>
									<td><?= $data['Student']['student_number']?></td>
									<td><?= $data['Student']['grade']?></td>
									<td>
										<?php
											for($i=0;$i<count($data);$i++)
											{
												if (array_key_exists($data['Student']['major_id'], $major))
												{
													echo $major[$data['Student']['major_id']];
												}
												else
												{
													echo "未登録";
												}
											}
										?>
									</td>
									<td><a href="/attendance_system/admin/students/detail/<?= $data['Student']['id']?>/<?= $data['Student']['major_id']?>"><i class="fa fa-info-circle" aria-hidden="true"></i></a></td>
									<td><a href="/attendance_system/admin/students/edit/<?= $data['Student']['id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
									<td><a href="/attendance_system/admin/students/delete/<?= $data['Student']['id']?>" onclick="return confirm('学生を削除します、よろしいですか？');"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>