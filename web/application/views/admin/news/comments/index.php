<?php
/*
Copyright (c) 2014 LiteDevel

Данная лицензия разрешает лицам, получившим копию данного программного обеспечения
и сопутствующей документации (в дальнейшем именуемыми «Программное Обеспечение»),
безвозмездно использовать Программное Обеспечение в  личных целях, включая неограниченное
право на использование, копирование, изменение, добавление, публикацию, распространение,
также как и лицам, которым запрещенно использовать Програмное Обеспечение в коммерческих целях,
предоставляется данное Программное Обеспечение,при соблюдении следующих условий:

Developed by LiteDevel
*/
?>
<?php echo $header ?>
				<div class="page-header">
					<h1>Все комментарии новостей</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Пользователь</th>
							<th>Текст</th>
							<th>Новость</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($comments as $item): ?> 
						<tr class="success" onClick="redirect('/admin/news/comments/edit/index/<?php echo $item['news_comment_id'] ?>')" >
							<td>#<?php echo $item['news_comment_id'] ?></td>
							<td><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></td>
							<td><?php echo mb_substr($item['news_comment_text'], 0, 32) ?></td>
							<td><?php echo $item['news_title'] ?></td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['news_comment_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($comments)): ?> 
						<tr>
							<td colspan="5" class="text-center">На данный момент нет комментариев новостей.</td>
						<tr>
						<?php endif; ?>
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
