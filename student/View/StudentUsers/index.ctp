<div>
	<h3><?= $student_info['school_name']?></h3>
	<p><?= $student_info['name'] ?>さんよこそ</p>
</div>

<!-- パスワードを変えるmodal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="loginmodal-container">
			<p>パスワードを変えます</p>
			<?= $this->Form->create('StudentUser', ['url' => 'edit'])?>
				<?= $this->Form->input('current_password', ['type' => 'password', 'label' => false, 'placeholder' => '現在のパスワード', 'required'])?>
				<?= $this->Form->input('new_password', ['type' => 'password', 'label' => false, 'placeholder' => '新しいパスワード', 'required'])?>
				<button type="submit" class="btn btn-success">登録</button>
			<?= $this->Form->end()?>
		</div>
	</div>
</div>
<!-- 時計と出席授業 -->
<div class="panel panel-primary">
	<div class="panel-heading"><div id="clock" class="clock">読み込み中 ...</div></div>
	<div class="panel-body">
		<?php foreach($all_class as $class) :?>
			<?php if($class['week'] == date('w')) :?>
				<!-- 授業ある日は一日中ではなく、開始前15分から開始後15分 -->
				<?php if(date('H:i:s') > date('H:i:s', strtotime("-15minutes", strtotime($class['start_time']))) && date('H:i:s') < date('H:i:s', strtotime("+15minutes", strtotime($class['start_time'])))) :?>
					<div class="thumbnail col-sm-6">
						<h3><?= $class['name']?>教室</h3>
						<h4><?= $class['subject']['Subject']['name']?>授業</h4>
						<p>授業時間: <?= $class['start_time'].'~'.$class['end_time']?></p>
						<?php if($is_attending == False) :?>
							<span class="btn btn-success attendbtn" id="<?= $class['id']?>">出席する</span>
						<?php else: ?>
							<span class="label label-info">出席しています</span>
						<?php endif ?>
					</div>
				<?php endif ?>
			<?php endif ?>
		<?php endforeach ?>
	</div>
</div>

<!-- 時間割 -->

<script>
// 時計
$('#clock').fitText(1.3);
function update() {
	$('#clock').html(moment().format('YYYY-MM-D H:mm:ss'));
}

setInterval(update, 1000);

// attend
$(".attendbtn").on("click", function(){
	$.ajax({
		url : "/attendance_system/student/student_users/attend",
		type : "POST",
		data : {class_id : $(this).attr('id')},
		dataType : "json",
		success : function (response) {
		//通信成功時の処理
			if (response.code == 200)
			{
				location.href='/attendance_system/student/student_users';
			}
		},
		error : function () {
		//通信失敗
			alert('ajax 通信失敗しました');
		}
	});
})
</script>