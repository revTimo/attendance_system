<p>お知らせ一覧</p>
<?php foreach ($show_all_notifications as $all_notification) :?>
<h3 align="left"><?= $all_notification['Notification']['title']?></h3>
<p><?= $all_notification['Notification']['content']?></p>
<hr>
<?php endforeach ?>
<br>
<ul class="pagination">
	<li><?= $this->Paginator->numbers(array('separator' => ' ')) ?></li>
</ul>