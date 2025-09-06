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
		<form class="form-signin" id="restoreForm" action="#" method="POST">
			<h2 class="form-signin-heading">Восставновление</h2>
			<input type="text" class="form-control" id="email" name="email" placeholder="E-Mail">
			<div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_client ?>"></div>
			<br>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Восстановить</button>
			<div class="other-link"><a href="/account/reset">Уже есть ключ восстановления?</a></div>
			<div class="other-link"><a href="/account/login">Вернуться к Авторизации</a></div>
		</form>
		<script>
			$('#restoreForm').ajaxForm({ 
				url: '/account/restore/ajax',
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
							setTimeout("redirect('/account/reset')", 1500);
							break;
					}
				},
				beforeSubmit: function(arr, $form, options) {
					$('button[type=submit]').prop('disabled', true);
				}
			});
		</script>
<?php echo $loginfooter ?>
