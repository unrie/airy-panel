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
					<h1>Все запросы</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Пользователь</th>
							<th>Тема</th>
							<th>Категория</th>
							<th>Сервер</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($tickets as $item): ?> 
						<tr class="<?php if($item['ticket_status'] == 0){echo 'info';} elseif($item['ticket_status'] == 1){echo 'warning';} elseif($item['ticket_status'] == 2){echo 'success';}?>" onClick="redirect('/admin/tickets/view/index/<?php echo $item['ticket_id'] ?>')">
							<td>#<?php echo $item['ticket_id'] ?></td>
							<td>
								<?php if($item['ticket_status'] == 0): ?> 
								<span class="label label-info">Закрыт</span>
								<?php elseif($item['ticket_status'] == 1): ?> 
								<span class="label label-warning">Ответ от клиента</span>
								<?php elseif($item['ticket_status'] == 2): ?> 
								<span class="label label-success">Ответ от поддержки</span>
								<?php endif; ?> 
							</td>
							<td><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></td>
							<td><?php echo $item['ticket_name'] ?></td>
							<td><?php echo $item['ticket_category_name'] ?></td>
							<td>
							  <?php if($item['server_id'] == 0): ?>
							  Не выбран
							  <?php else: ?>
							  gs<?php echo $item['server_id'] ?>
							  <?php endif; ?>
							</td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['ticket_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($tickets)): ?> 
						<tr>
							<td colspan="7" style="text-align: center;">На данный момент нет запросов.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
