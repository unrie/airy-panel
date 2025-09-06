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
					<h1>Управление сервером</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<div class="panel panel-<?php if($server['server_status'] == 0){echo 'warning';}elseif($server['server_status'] == 1){echo 'danger';}elseif($server['server_status'] == 2){echo 'success';}elseif($server['server_status'] == 3){echo 'warning';}?>">
					<div class="panel-heading">Информация о сервере</div>
					<table class="table table-bordered">
						<tr>
							<th width="200px" rowspan="11">
								<div align="center">
								  <img src="<?php echo $server['game_image_url'] ?>" style="width:140px; margin-bottom:5px;">
								</div>
								<?php if($server['server_status'] == 0): ?> 
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-warning" onClick="sendAction(<?php echo $server['server_id'] ?>,'unblock')"><span class="glyphicon glyphicon-lock"></span> Разблокировать</button>
								<?php elseif($server['server_status'] == 1): ?> 
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-success" onClick="sendAction(<?php echo $server['server_id'] ?>,'start')"><span class="glyphicon glyphicon-off"></span> Включить</button>
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-warning" onClick="sendAction(<?php echo $server['server_id'] ?>,'reinstall')"><span class="glyphicon glyphicon-refresh"></span> Переустановить</button>
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-primary" onClick="sendAction(<?php echo $server['server_id'] ?>,'backup')"><span class="glyphicon glyphicon-cloud"></span> Сделать backup</button>
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-warning" onClick="sendAction(<?php echo $server['server_id'] ?>,'block')"><span class="glyphicon glyphicon-lock"></span> Заблокировать</button>
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-danger" onClick="sendAction(<?php echo $server['server_id'] ?>,'delete')"><span class="glyphicon glyphicon-trash"></span> Удалить</button>
								<?php elseif($server['server_status'] == 2): ?> 
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-danger" onClick="sendAction(<?php echo $server['server_id'] ?>,'stop')"><span class="glyphicon glyphicon-off"></span> Выключить</button>
								<button style="width: 100%; margin-bottom: 5px;" type="button" class="btn btn-info" onClick="sendAction(<?php echo $server['server_id'] ?>,'restart')"><span class="glyphicon glyphicon-refresh"></span> Перезапустить</button>
								<?php endif; ?>
							</th>
						  <th>Игра:</th>
							<td><?php echo $server['game_name'] ?></td>
						</tr>
						<?php if($server['server_status'] == 2): ?>
						<?php if($query): ?> 
						<tr>
							<th>Название:</th>
							<td><?php echo iconv('windows-1251', 'utf-8', $query['hostname']) ?></td>
						</tr>
						<tr>
							<th>Игроки:</th>
							<td><?php echo $query['players'] ?> из <?php echo $query['maxplayers'] ?></td>
						</tr>
						<tr>
							<th>Игровой режим:</th>
							<td><?php echo iconv('windows-1251', 'utf-8', $query['gamemode']) ?></td>
						</tr>
						<tr>
							<th>Карта:</th>
							<td><?php echo iconv('windows-1251', 'utf-8', $query['mapname']) ?></td>
						</tr>
						<?php elseif(!$query): ?> 
						<tr>
							<th>Название:</th>
							<td><span class="label label-info">Нет данных</span></td>
						</tr>
						<tr>
							<th>Игроки:</th>
							<td><span class="label label-info">Нет данных</span></td>
						</tr>
						<tr>
							<th>Игровой режим:</th>
							<td><span class="label label-info">Нет данных</span></td>
						</tr>
						<tr>
							<th>Карта:</th>
							<td><span class="label label-info">Нет данных</span></td>
						</tr>
						<?php endif; ?>
						<?php endif; ?>
						<tr>
							<th>Локация:</th>
							<td><?php echo $server['location_name'] ?></td>
						</tr>
						<tr>
							<th>Адрес:</th>
							<td><?php echo $server['location_ip'] ?>:<?php echo $server['server_port'] ?></td>
						  <td><button type="button" class="btn btn-default btn-xs" data-clipboard-text="<?php echo $server['location_ip'] ?>:<?php echo $server['server_port'] ?>"><span class="glyphicon glyphicon-play"></span> Копировать</a></td>
						</tr>
						<tr>
							<th>Слоты:</th>
							<td><?php echo $server['server_slots'] ?></td>
						</tr>
						<tr>
							<th>Пользователь:</th>
							<td><a href="/admin/users/edit/index/<?php echo $server['user_id'] ?>"><?php echo $server['user_firstname'] ?> <?php echo $server['user_lastname'] ?></a></td>
						</tr>
						<tr>
							<th>Дата окончания оплаты:</th>
							<td><?php echo date("d.m.Y", strtotime($server['server_date_end'])) ?></td>
						</tr>
						<tr>
							<th>Статус:</th>
							<td>
								<?php if($server['server_status'] == 0): ?> 
								<span class="label label-warning">Заблокирован</span>
								<?php elseif($server['server_status'] == 1): ?> 
								<span class="label label-danger">Выключен</span>
								<?php elseif($server['server_status'] == 2): ?> 
								<span class="label label-success">Включен</span>
								<?php elseif($server['server_status'] == 3): ?> 
								<span class="label label-warning">Установка</span>
								<?php endif; ?> 
							</td>
						</tr>
					</table>
				</div>
				<script>
					function sendAction(serverid, action) {
						switch(action) {
							case "delete":
							{
								if(!confirm("Вы уверенны в том, что хотите удалить сервер? Все данные будут удалены.")) return;
								break;
							}
							case "reinstall":
							{
								if(!confirm("Вы уверенны в том, что хотите переустановить сервер? Все данные будут удалены.")) return;
								break;
							}
							case "backup":
							{
								if(!confirm("Вы уверенны в том, что хотите сделать backup сервера?")) return;
								break;
							}
						}
						$.ajax({ 
							url: '/admin/servers/control/action/'+serverid+'/'+action,
							dataType: 'text',
							success: function(data) {
								console.log(data);
								data = $.parseJSON(data);
								switch(data.status) {
									case 'error':
										showError(data.error);
										$('#controlBtns button').prop('disabled', false);
										break;
									case 'success':
										showSuccess(data.success);
										setTimeout("reload()", 1500);
										break;
								}
							},
							beforeSend: function(arr, options) {
								if(action == "reinstall") showWarning("Сервер будет переустановлен в течении 10 минут!");
								if(action == "backup") showWarning("Backup сервера будет сделан в течении 10 минут!");
								$('#controlBtns button').prop('disabled', true);
							}
						});
					}
					var clipboard = new ClipboardJS('.btn');
					clipboard.on('success', function(e) {
					  showSuccess("Вы успешно скопировали адрес сервера!");
          });
          clipboard.on('error', function(e) {
            showError("Не удалось скопировать адрес сервера!");
          });
				</script>
<?php echo $footer ?>
