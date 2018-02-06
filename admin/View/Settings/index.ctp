<h2>設定ページ</h2>

<p>遅刻時間を設定しない場合デフォルトとして５分になっています。<br>
※注意：設定した場合、全ての授業の遅刻時間に反映されます</p>

<div class="col-md-6">
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">遅刻時間設定</h3>
			<div class="box-tools pull-right">
				<?php if($setting_info['is_set'] == 1):?>
					<input type="checkbox" id="toggle-two" checked="" class="checkbox_check" data-onstyle="danger">
				<?php else :?>
					<input type="checkbox" id="toggle-two" data-onstyle="danger">
				<?php endif?>
			</div>
		</div>
		<div class="box-body">
			<div class="row　no-padding" id="set_time">
				<p class="text-red" id="alert_setting">現在の遅刻時間設定は無効になっています。有効にしてから登録してください</p>
			</div>
		</div>
	</div>
</div>
<script>
if ($('input.checkbox_check').is(':checked')) {
	$("#set_time").empty().append('<p class="text-red" id="alert_setting">現在の遅刻時間<?= $setting_info['value']?>分になっています。</p><?= $this->Form->create("Setting",["url" => "set_latetime"])?><div class="col-xs-3"><?= $this->Form->input("late_limit_time", ["label" => false, "class" => "form-control", "required", "min" => "0", "max" => "60", "value" => $setting_info['value']]) ?></div><button type="submit" class="btn btn-primary btn-sm">編集する</button><?= $this->Form->end()?>');
	$("#toggle-two").change(function() {
		if (confirm('デフォルトの設定に戻ります。よろしいですか？') == false)
		{
			return;
		}
		
		$.ajax({
			url : "/attendance_system/admin/settings/set_default",
			type : "POST",
			dataType : "text",
			success : function (response) {
			//通信成功時の処理
				if (response == 200)
				{
					location.href='/attendance_system/admin/settings/index';
				} else {
					alert('Setting システムエラーが発生しました。');
					location.href='/attendance_system/admin/settings/index';
				}
			},
			error : function () {
				//通信失敗
				alert('ajax 通信失敗しました');
			}
		});
	})
}　else {
	$("#toggle-two").change(function() {
		if(this.checked) {
			$("#set_time").empty().append('<?= $this->Form->create('Setting',['url' => 'set_latetime'])?><div class="col-xs-3"><?= $this->Form->input('late_limit_time', ['label' => false, 'class' => 'form-control', 'required', 'min' => '0', 'max' => '60']) ?></div><button type="submit" class="btn btn-primary">設定する</button><?= $this->Form->end()?>');
		} else {
		$("#set_time").empty().append('<p class="text-red" id="alert_setting">現在の遅刻時間設定は無効になっています。有効にしてから登録してください</p>');
		}
	});
}
$(function() {
	$('#toggle-two').bootstrapToggle({
		on: '有効',
		off: '無効'
	});
 })
</script>
