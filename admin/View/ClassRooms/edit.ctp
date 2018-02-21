<!-- 教室登録確認画面 -->
<style>
	.remove_student {
		cursor: pointer;
	}
</style>
<?= $this->Form->create('ClassRoom',['url' => 'edit/'.$data['id']])?>
<div class="col-md-6">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">以下の内容で編集されます</h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<label for="name">教室名</label>
				<?= $this->Form->input('name',['label' => false,'class' => 'form-control','required', 'value' => $data['name']]) ?>
			</div>
			<div class="form-group sub">
				<label for="name">科目</label>
				<?= $this->Form->input('subject_id', [
					'label' => false,
					'class' => 'select2 col-md-12',
					'id' => "changeSubject",
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
			<div class="form-group">
				<label for="name">曜日</label>
				<?= $this->Form->input('week', [
					'label' => false,
					'class' => 'select2 col-md-12',
					'options' => ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
					'selected' => $data['week'],
				])?>
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
	<div class="box box-default">
		<div class="box-header with-border">
			<div class="has-feedback">
				<input type="text" name="search_student" id="search_student" class="form-control input-sm" placeholder="学生名で検索">
				<span class="glyphicon glyphicon-search form-control-feedback"></span>
			</div>
		</div>
		<div class="box-body padding">
			<div class="student_result">
				<p class="show_std"></p>
			</div>
		</div>
	</div>
	<div class="box box-info">
		<div class="box-header with-border">
			<h3 class="box-title">授業を受ける学生</h3>
			<div class="box-tools pull-right">
				<span class="label label-danger ninnn"></span>
			</div>
		</div>
		<div class="box-body no-padding">
			<div class="std_list">
			<ul class="users-list clearfix　atda">
				<?php foreach($student_list as $key => $student) :?>
				<li id="<?= $key?>" class="std">
					<img src="/attendance_system/admin/webroot/student_image/<?= $student['img']?>" alt="User Image">
					<a class="users-list-name" href="#"><?=$student['name']?></a>
					<span class="users-list-date"><?=$student['major']['Major']['name']?></span>
					<?= $this->Form->input("ClassRoom.students_id.$key", ['type' => 'hidden', 'value' => $student['id'], 'id' => $student['id']]) ?>
					<span class="label label-danger remove_student" onclick="remove_me(this)">削除</span>
				</li>
				<?php endforeach ?>
			</ul>
			</div>
		</div>
	</div>
</div>
<!-- form 終了タグ -->
<?= $this->Form->end() ?>
<script>
$(".ninnn").text($(".std_list li").length+" 人");

$("#changeSubject").change(function(){
	$.ajax({
		url : "/attendance_system/admin/class_rooms/call_student",
		type : "POST",
		data : {id : $(".select2").val()},
		dataType : "json",
		success : function (response) {
			//通信成功時の処理
			$(".std").remove();
			for(var i=0; i<response.length; i++)
			{
				$('.std_list ul').append('<li id="'+i+'" class="std"><img src="/attendance_system/admin/webroot/student_image/'+response[i].img+'"><a class="users-list-name" href="#">'+response[i].name+'</a><span class="users-list-date">'+response[i]['major']['Major'].name+'</span><input type="hidden" name="data[ClassRoom][students_id]['+i+']" value="'+response[i].id+'" id="'+response[i].id+'"><span onclick="remove_me(this)" class="label label-danger remove_student">削除</span></li>');
			}
		},
		error : function () {
			//通信失敗
			alert('ajax 通信失敗しました');
		}
	});
})

$("#search_student").keyup(function(){
	$.ajax({
		url : "/attendance_system/admin/students/search_student",
		type : "POST",
		data : {name : $("input#search_student").val(), status : "search"},
		dataType : "json",
		success : function (response) {
			$('.show_std').empty();
			for (var i=0; i<response.length; i++)
			{
				$(".show_std").append('<p id="'+response[i]['Student'].id+'" style="background-color: #f5f5f5; cursor: pointer;">'+response[i]['Student'].name+'</p>'+" ");
				$("p.show_std > p#"+response[i]['Student'].id).on("click", function() {
				    $(this).empty();
				    add_student($(this).attr('id'), i);
				});
			}
		},
		error : function () {
			// 通信失敗
			$('.show_std').empty();
		}
	});
})

function add_student (std_id, i) {
	$.ajax({
		url : "/attendance_system/admin/students/search_student",
		type : "POST",
		data : {
			name : $("input#search_student").val(), status : "add_student", student_id :std_id
		},
		dataType : "json",
		success : function (response) {
			$('.std_list ul').append('<li class="std"><img src="/attendance_system/admin/webroot/student_image/'+response.img+'"><a class="users-list-name" href="#">'+response.name+'</a><span class="users-list-date">'+response['major']['Major'].name+'</span><input type="hidden" name="data[ClassRoom][students_id]['+Math.floor(Math.random() * $(".std_list li").length)+(1)+']" value="'+response.id+'" id="'+response.id+'"><span onclick="remove_me(this)" class="label label-danger remove_student">削除</span></li>');
			$(".ninnn").text($(".std_list li").length+" 人");
		},
		error : function () {
			// 通信失敗
			$('.show_std').empty();
		}
	});
}

function remove_me(arg)
{
	if (confirm('学生が授業から外されます、よろしいですか？') == false)
	{
		return;
	}
	$(arg).parent().remove();
	$(".ninnn").text($(".std_list li").length+" 人");
}
</script>