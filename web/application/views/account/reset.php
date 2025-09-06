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
<?php echo $loginheader ?>
		<form class="form-signin" id="resetForm" action="#" method="POST">
			<h2 class="form-signin-heading">Сброс</h2>
			<div class="form-group-vertical">
			  <div class="input-group">
			    <input type="password" class="form-control" id="password" name="password" placeholder="Новый пароль">
			    <span class="input-group-btn"><button class="btn btn-default btn-lg" type="button" onClick="randomPassword()"><span class="glyphicon glyphicon-random"></span></button></span>
			  </div>
			  <input type="password" class="form-control" id="password2" name="password2" placeholder="Повтор нового пароля">
			</div>
			<input type="text" class="form-control" id="restorekey" name="restorekey" placeholder="Ключ восстановления">
			<button class="btn btn-lg btn-primary btn-block" type="submit">Сбросить</button>
			<div class="other-link"><a href="/account/restore">Вернуться к Восстановлению</a></div>
		</form>
		<script>
			$('#resetForm').ajaxForm({ 
				url: '/account/reset/ajax',
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
							setTimeout("redirect('/')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});
			
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
<?php echo $loginfooter ?>
