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
					<h1><span class="greeting"></span>, <?php echo $user_firstname ?>!</h1>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Информация о вашем аккаунте</div>
					<table class="table table-bordered">
						<tbody><tr>
							<th width="200px" rowspan="5">
								<div align="center"><img src="/application/public/img/user.png" style="width:140px; margin-bottom:5px;"></div>
							</th>
							<th>ID аккаунта:</th>
							<td>№<?php echo $user_id; ?></td>
						</tr>
						<tr>
							<th>Имя Фамилия:</th>
							<td><?php echo $user_firstname ?> <?php echo $user_lastname ?></td>
						</tr>
						<tr>
							<th>E-Mail:</th>
							<td><?php echo $user_email ?></td>
						</tr>
						<tr>
							<th>Баланс:</th>
							<td><?php echo $user_balance ?> руб.</td>
						</tr>
						<tr>
							<th>Дата регистрации:</th>
							<td><?php echo date("d.m.Y в H:i", strtotime($user_date_reg)) ?></td>
						</tr>
					</tbody></table>
				</div>
				<h2>Ваши серверы</h2>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Игра</th>
							<th>Локация</th>
							<th>Адрес</th>
							<th>Слоты</th>
							<th>Дата окончания оплаты</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($servers as $item): ?> 
						<tr class="<?php if($item['server_status'] == 0){echo 'warning';}elseif($item['server_status'] == 1){echo 'danger';}elseif($item['server_status'] == 2){echo 'success';}elseif($item['server_status'] == 3){echo 'warning';}?>" onClick="redirect('/servers/control/index/<?php echo $item['server_id'] ?>')">
							<td>№<?php echo $item['server_id'] ?></td>
							<td>
							<?php if($item['server_status'] == 0): ?> 
								<span class="label label-warning">Заблокирован</span>
							<?php elseif($item['server_status'] == 1): ?> 
								<span class="label label-danger">Выключен</span>
							<?php elseif($item['server_status'] == 2): ?> 
								<span class="label label-success">Включен</span>
							<?php elseif($item['server_status'] == 3): ?> 
								<span class="label label-warning">Установка</span>
							<?php endif; ?> 
							</td>
							<td><?php echo $item['game_name'] ?></td>
							<td><?php echo $item['location_name'] ?></td>
							<td><?php echo $item['location_ip2'] ?>:<?php echo $item['server_port'] ?></td>
							<td><?php echo $item['server_slots'] ?></td>
							<td><?php echo date("d.m.Y", strtotime($item['server_date_end'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($servers)): ?> 
						<tr>
							<td colspan="7" style="text-align: center;">На данный момент у вас нет серверов.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<h2>Ваши запросы</h2>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Тема</th>
							<th>Категория</th>
							<th>Сервер</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($tickets as $item): ?> 
						<tr class="<?php if($item['ticket_status'] == 0){echo 'info';}elseif($item['ticket_status'] == 1){echo 'warning';}elseif($item['ticket_status'] == 2){echo 'success';}?>" onClick="redirect('/tickets/view/index/<?php echo $item['ticket_id'] ?>')">
							<td>№<?php echo $item['ticket_id'] ?></td>
							<td>
								<?php if($item['ticket_status'] == 0): ?> 
								<span class="label label-info">Закрыт</span>
								<?php elseif($item['ticket_status'] == 1): ?> 
								<span class="label label-warning">Ответ от клиента</span>
								<?php elseif($item['ticket_status'] == 2): ?> 
								<span class="label label-success">Ответ от поддержки</span>
								<?php endif; ?>  
							</td>
							<td><?php echo $item['ticket_name'] ?></td>
							<td><?php echo $item['ticket_category_name'] ?></td>
							<td>
							  <?php if($item['server_id'] != 0): ?>
							  gs<?php echo $item['server_id'] ?>
							  <?php else: ?>
							  Не выбран
							  <?php endif; ?>
							</td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['ticket_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($tickets)): ?> 
						<tr>
							<td colspan="6" style="text-align: center;">На данный момент у вас нет запросов.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<h2>Ваши логи авторизаций</h2>
        <table class="table">
					<thead>
						<tr>
							<th>Статус</th>
							<th>IP-адрес</th>
							<th>Страна</th>
							<th>Дата создания</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($authlogs as $item):?> 
						<tr class="<?php if($item['authlog_status'] == 0){echo 'danger';}elseif($item['authlog_status'] == 1){echo 'success';}elseif($item['authlog_status'] == 2){echo 'warning';}?>">
							<td>
								<?php if($item['authlog_status'] == 0): ?> 
								<span class="label label-danger">Ошибка входа</span>
								<?php elseif($item['authlog_status'] == 1): ?> 
								<span class="label label-success">Вход в систему</span>
								<?php elseif($item['authlog_status'] == 2): ?> 
								<span class="label label-warning">Выход из системы</span>
								<?php endif; ?>  
							</td>
							<td><?php echo $item['authlog_ip'] ?></td>
							<td><?php echo $item['authlog_country'] ?></td>
							<td><?php echo date("d.m.Y в H:i", strtotime($item['authlog_date_add'])) ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($authlogs)): ?> 
						<tr>
							<td colspan="4" style="text-align: center;">На данный момент у вас нет логов авторизаций.</td>
						<tr>
						<?php endif; ?> 
					</tbody>
				</table>
				<script>
				  var day = new Date(); 
          var hour = day.getHours(); 
          if (hour >= 5 && hour < 12) {
            $('h1 .greeting').text('Доброе утро');
          } else if (hour >= 0 && hour < 5) {
            $('h1 .greeting').text('Доброй ночи');
          } else if (hour >= 12 && hour < 18) {
            $('h1 .greeting').text('Добрый день');
          } else if (hour >= 18 && hour < 24) {
            $('h1 .greeting').text('Добрый вечер');
          }
				</script>
<?php echo $footer ?>
