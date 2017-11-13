<!-- 学科登録 -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><strong>学科登録</strong></div>
			<div class="panel-body">  
				<?= $this->Form->create('Subject',['url' => 'confirm_subject'])?>
				<div class="form-group">
					<label for="name">専攻名</label>
					<?= $this->Form->input('major_name',['label' => false,'class' => 'form-control','required']) ?>
				</div>
				<div class="form-group sub">
					<label for="name">科目</label>
					<?= $this->Form->input('Subject.subjects.0',['label' => false,'class' => 'form-control sub_clone','required','id' => 'myid']) ?>
					<button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this)">削除</button> 
				</div>
				<span class="clone"></span>
				<button type="button" class="btn btn-primary btn-xs" id="subject_add">追加</button><br><br>
				<button type="submit" class="btn btn-primary">確認画面へ</button>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>

<!-- 一覧 -->
<div class="box">
   <div class="box-header">
      <h3 class="box-title">学科一覧</h3>
   </div>
   <div class="box-body">
      <table id="example1" class="table table-bordered table-striped">
         <thead>
            <tr>
               <th>専攻</th>
               <th>科目</th>
               <th>編集</th>
               <th>削除</th>
            </tr>
         </thead>
         <tbody>
         	<?php foreach ($majors_subjects as $data) : ?>
            <tr>
               <td><?= $data['Major']['name'] ?></td>
               <td>
               	<?php foreach($data['Subject'] as $sub) :?>
               	<?= $sub['name']?>
               	<?php endforeach ?>
               	</td>
               	<td><a href="edit/<?= $data['Major']['id']?>">edit</a></td>
               	<td><a href="">delete</a></td>
            </tr>
        	<?php endforeach ?>
         </tbody>
      </table>
   </div>
</div>


<script>
	$(document).ready(function(){
		var subject_clone_count = 1;
		$("#subject_add").click(function(){
			$(".clone").append('<div class="form-group sub"><label for="name">科目</label><?= $this->Form->input("Subject.subjects.'+subject_clone_count+'",["label" => false,"class" => "form-control sub_clone","required"]) ?><button type="button" class="btn btn-danger btn-xs" onclick="remove_item(this)">削除</button></div><br>');
			subject_clone_count++;
		});
	});

	function remove_item(target) {
		$(target).parents('.sub').remove();
	}

	$(function () {
		//日本語にする
		$.extend( $.fn.dataTable.defaults, { 
			language: {
				url: "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Japanese.json"
			}
		});
		$('#example1').DataTable()
		$('#example2').DataTable({
			'paging'      : true,
			'lengthChange': false,
			'searching'   : false,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : false
		});
	});
</script>