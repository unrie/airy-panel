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
					<h1>Все пользователи</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Имя</th>
							<th>Фамилия</th>
							<th>E-Mail</th>
							<th>Дата регистрации</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $item): ?> 
						<tr class="<?php if($item['user_status'] == 0){echo 'danger';} elseif($item['user_status'] == 1){echo 'success';} elseif($item['user_status'] == 2){echo 'warning';}?>" onClick="redirect('/admin/users/edit/index/<?php echo $item['user_id'] ?>')">
							<td>#<?php echo $item['user_id'] ?></td>
							<td>
							<?php if($item['user_status'] == 0): ?> 
								<span class="label label-danger">Заблокирован</span>
							<?php elseif($item['user_status'] == 1): ?> 
								<span class="label label-success">Активен</span>
							<?php endif; ?> 
							</td>
							</td>
							<td><?php echo $item['user_firstname'] ?></td>
							<td><?php echo $item['user_lastname'] ?></td>
							<td><?php echo $item['user_email'] ?></td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['user_date_reg'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($users)): ?> 
						<tr>
							<td colspan="6" style="text-align: center;">На данный момент нет пользователей.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
