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
					<h1>Редактирование сервера</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<h3>Пароль</h3>
				<form class="form-horizontal" action="#" id="editForm" method="POST">
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<div class="checkbox">
								<label><input type="checkbox" id="editpassword" name="editpassword" onChange="togglePassword()"> Изменить пароль</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Пароль:</label>
						<div class="col-sm-4">
						  <div class="input-group">
							  <input type="password" class="form-control" id="password" name="password" placeholder="Введите пароль" disabled>
							  <span class="input-group-btn"><button class="btn btn-default" type="button" onClick="randomPassword()"><span class="glyphicon glyphicon-random"></span></button></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password2" class="col-sm-3 control-label">Повтор пароля:</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="password2" name="password2" placeholder="Повторите пароль" disabled>
						</div>
					</div>
					<h3>Дополнительная информация</h3>
					<div class="form-group">
						<label for="monitoring" class="col-sm-3 control-label">Мониторинг:</label>
						<div class="col-sm-4">
							<select class="form-control" id="monitoring" name="monitoring">
							  <option value="0"<?php if($server['server_monitoring'] == 0): ?> selected="selected"<?php endif; ?>>Не отображать в мониторинге</option>
							  <option value="1"<?php if($server['server_monitoring'] == 1): ?> selected="selected"<?php endif; ?>>Отображать в мониторинге</option>
				      </select>
						</div>
					</div>
					<div class="form-group">
						<label for="autoup" class="col-sm-3 control-label">Автоподнятие:</label>
						<div class="col-sm-3">
							<select class="form-control" id="autoup" name="autoup">
							  <option value="0"<?php if($server['server_auto_up'] == 0): ?> selected="selected"<?php endif; ?>>Выключено</option>
							  <option value="1"<?php if($server['server_auto_up'] == 1): ?> selected="selected"<?php endif; ?>>Включено</option>
				      </select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Сохранить</button>
						</div>
					</div>
				</form>
				<script>
					$('#editForm').ajaxForm({ 
						url: '/admin/servers/edit/ajax/<?php echo $server['server_id'] ?>',
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
						}
					});
					
					function togglePassword() {
						var status = $('#editpassword').is(':checked');
						if(status) {
							$('#password').prop('disabled', false);
							$('#password2').prop('disabled', false);
						} else {
							$('#password').prop('disabled', true);
							$('#password2').prop('disabled', true);
						}
					}
					
					function plusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value+1);
						updateForm();
					}
					function minusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value-1);
						updateForm();
					}
					
					function randomPassword() {
		        var length = 8;
		        var result = '';
		        var symbols = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		        for (i = 0; i < length; i++) {
			        result += symbols.charAt(Math.floor(Math.random() * symbols.length));
		        }
		        $('#password').attr('type', 'text');
		        $('#password').val(result);
		        $('#password2').attr('type', 'text');
		        $('#password2').val(result);
	        }
				</script>
<?php echo $footer ?>
