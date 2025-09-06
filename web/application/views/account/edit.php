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
					<h1>Редактирование профиля</h1>
				</div>
				<form class="form-horizontal" action="#" id="editForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="firstname" class="col-sm-3 control-label">Имя:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Введите свое имя" value="<?php echo $user['firstname'] ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="lastname" class="col-sm-3 control-label">Фамилия:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Введите свою фамилию" value="<?php echo $user['lastname'] ?>">
						</div>
					</div>
					<h3>Пароль</h3>
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
							  <input type="password" class="form-control" id="password" name="password" placeholder="Пароль" disabled>
							  <span class="input-group-btn"><button class="btn btn-default" type="button" onClick="randomPassword()"><span class="glyphicon glyphicon-random"></span></button></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password2" class="col-sm-3 control-label">Повторите пароль:</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="password2" name="password2" placeholder="Повторите пароль" disabled>
						</div>
					</div>
					<h3>Дополнительная информация</h3>
					<div class="form-group">
						<label for="mailing" class="col-sm-3 control-label">Рассылка:</label>
						<div class="col-sm-4">
							<select class="form-control" id="mailing" name="mailing">
							  <option value="0"<?php if($user['mailing'] == 0): ?> selected="selected"<?php endif; ?>>Не получать новости на E-Mail</option>
							  <option value="1"<?php if($user['mailing'] == 1): ?> selected="selected"<?php endif; ?>>Получать новости на E-Mail</option>
				      </select>
						</div>
					</div>
					<div class="form-group">
						<label for="theme" class="col-sm-3 control-label">Тема:</label>
						<div class="col-sm-3">
							<select class="form-control" id="theme" name="theme">
							  <option value="0"<?php if($user['theme'] == 0): ?> selected="selected"<?php endif; ?>>Светлая</option>
							  <option value="1"<?php if($user['theme'] == 1): ?> selected="selected"<?php endif; ?>>Темная</option>
				      </select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Изменить</button>
						</div>
					</div>
				</form>
				<script>
					$('#editForm').ajaxForm({ 
						url: '/account/edit/ajax',
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
