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
					<h1>Статистика сервера</h1>
				</div>
				<?php include 'tabs.php'; ?>
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
								<?php if($server['server_status'] == 2): ?>
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
				</script>
<?php echo $footer ?>
