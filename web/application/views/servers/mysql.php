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
					<h1>MySQL доступ сервера</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<div class="alert alert-warning">
          <strong>Внимание!</strong> Для корректной работы сервера рекомендуется использовать плагин <b>mysql_static.so</b>!
        </div>
				<div class="panel panel-default">
					<div class="panel-heading">MySQL доступ сервера</div>
					<table class="table table-bordered">
						<tr>
							<th>Хост:</th>
							<td>127.0.0.1</td>
						</tr>
						<tr>
							<th>Логин:</th>
							<td>gs<?php echo $server['server_id'] ?></td>
						</tr>
						<tr>
							<th>Пароль:</th>
							<td><?php echo $server['server_password'] ?></td>
						</tr>
						<tr>
							<th>База данных:</th>
						  <td><button type="button" class="btn btn-primary btn-xs" onClick="window.open('http://<?php echo $server['location_ip'] ?>/phpmyadmin/')"><span class="glyphicon glyphicon-log-in"></span> Перейти</button></td>
						</tr>
					</table>
				</div>
<?php echo $footer ?>
