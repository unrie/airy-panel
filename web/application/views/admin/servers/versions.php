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
					<h1>Изменение версии сервера</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<form class="form-horizontal" action="#" id="versionsForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="months" class="col-sm-3 control-label">Версия:</label>
						<div class="col-sm-5">
							<select class="form-control" id="versionid" name="versionid">
							  <?php foreach($versions as $item): ?>
								<option value="<?php echo $item['game_id'] ?>"><?php echo $item['game_name'] ?></option>
							  <?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Изменить и переустановить</button>
						</div>
					</div>
				</form>
				<script>
					$('#versionsForm').ajaxForm({ 
						url: '/admin/servers/versions/ajax/<?php echo $server['server_id'] ?>',
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
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
							showWarning("Версия сервера будет изменена в течении 10 минут!");
						}
					});
				</script>
<?php echo $footer ?>
