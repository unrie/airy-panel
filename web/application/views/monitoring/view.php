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
					<h1>Информация о сервере №<?php echo $server['server_id'] ?></h1>
				</div>
				<div class="panel panel-success">
					<div class="panel-heading">Информация о сервере</div>
						<table class="table table-bordered">
						<tr>
							<th width="200px" rowspan="20">
								<div align="center">
								  <img src="<?php echo $server['game_image_url'] ?>" style="width:140px; margin-bottom:5px;">
								</div>
							</th>
							<th>ID сервера:</th>
							<td>№<?php echo $server['server_id'] ?></td>
						</tr>
						<tr>
						  <th>Игра:</th>
						  <td><?php echo $server['game_name'] ?></td>
						</tr>
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
					</table>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">Статистика сервера</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-5">
								<b>CPU нагрузка</b>
								<div class="progress progress-striped active">
									<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $server['server_cpu_load'] ?>%"></div>
								</div>
								<span class="label label-info"><?php echo $server['server_cpu_load'] ?>%</span>
								<hr>
								<b>RAM нагрузка</b>
								<div class="progress progress-striped active">
									<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $server['server_ram_load'] ?>%"></div>
								</div>
								<span class="label label-info"><?php echo $server['server_ram_load'] ?>%</span>
								<?php if($query): ?>
								<hr>
								<b>Загруженность сервера</b>
								<div class="progress progress-striped active">
									<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $serverload ?>%"></div>
								</div>
								<span class="label label-info"><?php echo $serverload ?>%</span>
								<?php elseif(!$query): ?>
								<hr>
								<b>Загруженность сервера</b>
								<div class="progress progress-striped active">
									<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
								</div>
								<span class="label label-info">0%</span>
								<?php endif; ?>
							</div>
							<div class="col-md-7">
								<div id="statsGraph" style="height: 220px;"></div>
							</div>
						</div>
					</div>
				</div>
				<?php if($server['game_query'] == 'mine'): ?>
				<div class="panel panel-default">
					<div class="panel-heading">Игроки на сервере</div>
				  <table class="table">
					  <thead>
						  <tr class="default">
							  <th>Ник</th>
						  </tr>
					  </thead>
					  <tbody>
				    <?php foreach($query['Playersnick'] as $Playernick): ?>
					  <tr>
				      <td><?php echo htmlspecialchars($Playernick); ?></td>
					  </tr>
            <?php endforeach; ?>
            <?php if(empty($query['Playersnick'])): ?> 
					  <tr>
						  <td colspan="1" style="text-align: center;">На данный момент на сервере нет игроков.</td>
					  <tr>
					  <?php endif; ?>
					 </tbody>
				  </table>
				</div>
				<?php endif; ?>
				<script>
					var serverStats = [
						<?php foreach($stats as $item): ?> 
						[<?php echo strtotime($item['server_stats_date']) * 1000 ?>, <?php echo $item['server_stats_players'] ?>],
						<?php endforeach; ?> 
					];
					$.plot($("#statsGraph"), [serverStats], {
						xaxis: {
							mode: "time",
							timeformat: "%H:%M"
						},
						yaxis: {
							min: 0,
							max: <?php echo $server['server_slots'] ?>
						},
						series: {
							lines: {
								show: true,
								fill: true
							},
							points: {
								show: true
							}
						},
						grid: {
							borderWidth: 0
						},
						colors: ["#428BCA"]
					});
					
					var clipboard = new ClipboardJS('.btn');
					clipboard.on('success', function(e) {
					  showSuccess("Вы успешно скопировали адрес сервера!");
          });
          clipboard.on('error', function(e) {
            showError("Не удалось скопировать адрес сервера!");
          });
				</script>
<?php echo $footer ?>
