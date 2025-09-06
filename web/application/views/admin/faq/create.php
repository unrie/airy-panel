<?php
/*
* @LitePanel
* @Version: 1.0.1
* @Date: 12.02.2014
* @Developed by RossyBAN
*/
?>
<?php echo $header ?>
        <div class="page-header">
				  <h1>Создание FAQ</h1>
				</div>
				<form class="form-horizontal" action="#" id="createForm" method="POST">
					  <h3>Основная информация</h3>
						<div class="form-group">
						<label for="name" class="col-sm-3 control-label">Название:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите заголовок">
						</div>
						</div>
						<div class="form-group">
							<label for="text" class="col-sm-3 control-label">Текст:</label>
							<div class="col-sm-7">
								<textarea id="text" name="text" class="form-control" rows="5" placeholder="Текст"></textarea>
							</div>
						</div>
						<h3>Дополнительная информация</h3>
						<div class="form-group">
						  <label for="status" class="col-sm-3 control-label">Статус:</label>
						  <div class="col-sm-3">
							  <select class="form-control" id="status" name="status">
								  <option value="0">Выключен</option>
								  <option value="1">Включен</option>
							  </select>
						  </div>
					  </div>
					  <div class="form-group">
						  <div class="col-sm-offset-3 col-sm-9">
							  <button type="submit" class="btn btn-primary">Создать</button>
						  </div>
					  </div>
				</form>
				<script>
					$('#createForm').ajaxForm({ 
						url: '/admin/faq/create/ajax',
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
									setTimeout("redirect('/admin/faq/index')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
				</script>
<?php echo $footer ?>
