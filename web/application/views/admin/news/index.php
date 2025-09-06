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
					<h1>Все новости</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Тип</th>
							<th>Добавил</th>
							<th>Заголовок</th>
							<th>Комментарии</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($news as $item): ?> 
						<tr class="<?php echo $item['news_type'] ?>" onClick="redirect('/admin/news/edit/index/<?php echo $item['news_id'] ?>')" >
							<td>#<?php echo $item['news_id'] ?></td>
							<td>
							<?php if($item['news_type'] == 'primary'): ?> 
							<span class="label label-primary">primary</span>
							<?php elseif($item['news_type'] == 'success'): ?> 
							<span class="label label-success">success</span>
							<?php elseif($item['news_type'] == 'danger'): ?> 
							<span class="label label-danger">danger</span>
							<?php elseif($item['news_type'] == 'warning'): ?> 
							<span class="label label-warning">warning</span>
							<?php elseif($item['news_type'] == 'info'): ?> 
							<span class="label label-info">info</span>
							<?php endif; ?>
							</td>
							<td><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></td>
							<td><?php echo $item['news_title'] ?></td>
							<td>
							<?php if($item['news_comments'] == 0): ?> 
							Выключены
							<?php elseif($item['news_comments'] == 1): ?> 
							Включены
							<?php endif; ?>
							</td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['news_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($news)): ?> 
						<tr>
							<td colspan="6" class="text-center">На данный момент нет новостей.</td>
						<tr>
						<?php endif; ?> 
						<tr>
							<td colspan="6" class="text-center"><a href="/admin/news/create" class="btn btn-default">Создать новость</a></td>
						</tr>
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
