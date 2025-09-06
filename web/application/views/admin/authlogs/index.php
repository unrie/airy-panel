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
					<h1>Все логи авторизаций</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
						  <th>ID</th>
							<th>Статус</th>
							<th>Пользователь</th>
							<th>IP-адрес</th>
							<th>Страна</th>
							<th>Город</th>
							<th>Провайдер</th>
							<th>Дата создания</th>
						</tr>
						</tr>
					</thead>
					<tbody>
						<?php foreach($authlogs as $item):?> 
						<tr class="<?php if($item['authlog_status'] == 0){echo 'danger';}elseif($item['authlog_status'] == 1){echo 'success';}elseif($item['authlog_status'] == 2){echo 'warning';}?>">
							<td>#<?php echo $item['authlog_id'] ?></td>
							<td>
								<?php if($item['authlog_status'] == 0): ?> 
								<span class="label label-danger">Ошибка входа</span>
								<?php elseif($item['authlog_status'] == 1): ?> 
								<span class="label label-success">Вход в систему</span>
								<?php elseif($item['authlog_status'] == 2): ?> 
								<span class="label label-warning">Выход из системы</span>
								<?php endif; ?>  
							</td>
							<td><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></td>
							<td><?php echo $item['authlog_ip'] ?></td>
							<td><?php echo $item['authlog_country'] ?></td>
							<td><?php echo $item['authlog_city'] ?></td>
							<td><?php echo $item['authlog_isp'] ?></td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['authlog_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($authlogs)): ?> 
						<tr>
							<td colspan="8" style="text-align: center;">На данный момент нет логов авторизаций.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
