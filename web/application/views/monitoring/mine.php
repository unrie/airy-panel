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
					<h1>Мониторинг серверов Minecraft</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<div class="panel panel-default">
				  <div class="panel-heading">Мониторинг серверов Minecraft</div>
				    <table class="table">
					    <thead>
						    <tr>
						      <th>ID</th>
							    <th>Игра</th>
							    <th>Название</th>
							    <th>Игроки</th>
							    <th>Игровой режим</th>
							    <th>Карта</th>
							    <th>Локация</th>
							    <th>IP</th>
						    </tr>
					    </thead>
					    <tbody>
					    <?php
					    $monitoringservers = 0;
					    $players = 0;
					    ?>
						  <?php foreach($servers as $item): ?> 
						  <?php
						  $queryLib = new queryLibrary($item['game_query']);
			        $queryLib->connect($item['location_ip'], $item['server_port']);
			        $query = $queryLib->getInfo();
			        $queryLib->disconnect();
			      
			        $monitoringservers++;
			        $players += $query['players'];
			        ?>
			        <?php
			        if (!$query) {
                continue;
              }
              ?>
						  <tr class="success" onClick="redirect('/monitoring/view/index/<?php echo $item['server_id'] ?>')">
							  <td>№<?php echo $item['server_id'] ?></td>
							  <td><?php echo $item['game_name'] ?></td>
							  <td><?php echo iconv('windows-1251', 'utf-8', $query['hostname']) ?></td>
							  <td><?php echo $query['players'] ?> из <?php echo $query['maxplayers'] ?></td>
							  <td><?php echo iconv('windows-1251', 'utf-8', $query['gamemode']) ?></td>
							  <td><?php echo iconv('windows-1251', 'utf-8', $query['mapname']) ?></td>
							  <td><?php echo $item['location_name'] ?></td>
							  <td><?php echo $item['location_ip'] ?>:<?php echo $item['server_port'] ?></td>
						  </tr>
						  <?php endforeach; ?> 
						  <?php if(empty($servers)): ?> 
						  <tr>
							  <td colspan="8" style="text-align: center;">На данный момент нет включеных серверов.</td>
						  <tr>
						  <?php endif; ?> 
					    </tbody>
				    </table>
				    <div class="panel-footer">
						  <div class="row">
						    <div class="col-md-6 text-muted text-left">
								  <small><span class="glyphicon glyphicon-hdd"></span> Серверов в мониторинге: <?php echo $monitoringservers ?></small>
							  </div>
							  <div class="col-md-6 text-muted text-right">
								  <small><span class="glyphicon glyphicon-user"></span> Игроков на серверах: <?php echo $players ?></small>
							  </div>
						  </div>
					  </div>
				  </div>
				<?php echo $pagination ?> 
<?php echo $footer ?>
