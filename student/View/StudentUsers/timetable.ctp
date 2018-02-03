<!-- 時間割 -->
<div class="table-responsive-sm">
	<table class="table">
		<caption>時間割</caption>
		<thead>
			<tr>
				<th>日曜日</th>
				<th>月曜日</th>
				<th>火曜日</th>
				<th>水曜日</th>
				<th>木曜日</th>
				<th>金曜日</th>
				<th>土曜日</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<!-- 0日曜日 -->
				<td id="0">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 0):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 1月曜日 -->
				<td id="1">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 1):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 2火曜日 -->
				<td id="2">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 2):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 3水曜日 -->
				<td id="3">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 3):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 4木曜日 -->
				<td id="4">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 4):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 5金曜日 -->
				<td td="5">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 5):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
				<!-- 6土曜日 -->
				<td id="6">
					<?php foreach($all_class as $class) :?>
						<?php if($class['week'] == 6):?>
							<div class="thumbnail">
								<span class="timetable" data-toggle="popover" title="授業の詳細" data-content="<?= $class['name'].'教室'.'【'.''.$class['start_time'].'】'?>">
									<?php if(isset($class['subject']['Subject']['name'])) :?>
										<?= $class['subject']['Subject']['name'] ?>
									<?php else :?>
										<span>学科未定</span>
									<?php endif ?>
								</span>
							</div>
						<?php endif ?>
					<?php endforeach ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
	// timetable
$('[data-toggle="popover"]').popover();
</script>