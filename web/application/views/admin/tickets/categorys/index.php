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
					<h1>Все категории запросов</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Название</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($categorys as $item): ?> 
						<tr class="<?php if($item['ticket_category_status'] == 0){echo 'danger';} elseif($item['ticket_category_status'] == 1){echo 'success';} ?>" onClick="redirect('/admin/tickets/categorys/edit/index/<?php echo $item['ticket_category_id'] ?>')" >
							<td>#<?php echo $item['ticket_category_id'] ?></td>
							<td>
							<?php if($item['ticket_category_status'] == 0): ?> 
								<span class="label label-danger">Выключена</span>
							<?php elseif($item['ticket_category_status'] == 1): ?> 
								<span class="label label-success">Включена</span>
							<?php endif; ?>
							</td>
							<td><?php echo $item['ticket_category_name'] ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($categorys)): ?> 
						<tr>
							<td colspan="3" class="text-center">На данный момент нет категорий.</td>
						<tr>
						<?php endif; ?> 
						<tr>
							<td colspan="3" class="text-center"><a href="/admin/tickets/categorys/create" class="btn btn-default">Создать категорию</a></td>
						</tr>
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
