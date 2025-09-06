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
					<h1>Просмотр запроса #<?php echo $ticket['ticket_id'] ?></h1>
				</div>
    			<div class="panel panel-<?php if($ticket['ticket_status'] == 0){echo 'info';}elseif($ticket['ticket_status'] == 1){echo 'warning';}elseif($ticket['ticket_status'] == 2){echo 'success';}?>">
					<div class="panel-heading">Информация о запросе</div>
					<table class="table table-bordered">
						<tr>
							<th width="200px" rowspan="6">
								<div align="center">
								  <img src="/application/public/img/support.png" style="width:140px; margin-bottom:5px;">
								</div>
							</th>
							<th>ID запроса:</th>
							<td>#<?php echo $ticket['ticket_id'] ?></td>
						</tr>
						<tr>
							<th>Тема:</th>
							<td><?php echo $ticket['ticket_name'] ?></td>
						</tr>
						<tr>
							<th>Категория:</th>
							<td><?php echo $ticket['ticket_category_name'] ?></td>
						</tr>
						<tr>
							<th>Сервер:</th>
							<td>
							  <?php if($ticket['server_id'] == 0): ?>
							  Не выбран
							  <?php else: ?>
							  <a href="/admin/servers/control/index/<?php echo $ticket['server_id'] ?>">gs<?php echo $ticket['server_id'] ?></a>
							  <?php endif; ?>
							</td>
						</tr>
						<tr>
							<th>Дата создания:</th>
							<td><?php echo date("d.m.Y в H:i", strtotime($ticket['ticket_date_add'])) ?></td>
						</tr>
						<tr>
							<th>Статус:</th>
							<td>
								<?php if($ticket['ticket_status'] == 0): ?> 
								<span class="label label-info">Закрыт</span>
								<?php elseif($ticket['ticket_status'] == 1): ?> 
								<span class="label label-warning">Ответ от клиента</span>
								<?php elseif($ticket['ticket_status'] == 2): ?> 
								<span class="label label-success">Ответ от поддержки</span>
								<?php endif; ?> 
							</td>
						</tr>
					</table>
				</div>
				<?php foreach($messages as $item): ?> 
				<div class="panel panel-default"> 
					<div class="panel-body"><?php echo nl2br($item['ticket_message']) ?></div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6 text-muted text-left">
								<small><span class="glyphicon glyphicon-calendar"></span> <?php echo date("d.m.Y в H:i", strtotime($item['ticket_message_date_add'])) ?></small>
							</div>
							<div class="col-md-6 text-muted text-right">
								<small><span class="glyphicon glyphicon-user"></span> <a href="/admin/users/edit/index/<?php echo $item['user_id'] ?>"><?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></a></small>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?> 
				<?php if($ticket['ticket_status'] != 0): ?> 
				<h2>Отправить сообщение</h2>
				<form class="form-horizontal" id="sendForm" action="#" method="POST">
					<div class="form-group">
						<label for="text" class="col-sm-3 control-label">Текст:</label>
						<div class="col-sm-7">
							<textarea class="form-control" id="text" name="text" rows="3" placeholder="Введите текст сообщения"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label><input type="checkbox" id="closeticket" name="closeticket" onChange="toggleText()"> Закрыть запрос</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Отправить</button>
						</div>
					</div>
				</form>
				<script>
					$('#sendForm').ajaxForm({ 
						url: '/admin/tickets/view/ajax/<?php echo $ticket['ticket_id'] ?>',
						dataType: 'text',
						success: function(data) {
							console.log(data);
							data = $.parseJSON(data);
							switch(data.status) {
								case 'error':
									showError(data.error);
									$('button[type=submit]').prop('disabled', false);
									break;
								case 'success':
									showSuccess(data.success);
									$('#text').val('');
									setTimeout("reload()", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					function toggleText() {
						var status = $('#closeticket').is(':checked');
						if(status) {
							$('#text').prop('disabled', true);
						} else {
							$('#text').prop('disabled', false);
						}
					}
				</script>
				<?php endif; ?>
<?php echo $footer ?>
