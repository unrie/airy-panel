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
					<h1>Создать запрос</h1>
				</div>
				<form class="form-horizontal" action="#" id="createForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="text" class="col-sm-3 control-label">Тема:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите тему">
						</div>
					</div>
					<div class="form-group">
						<label for="categoryid" class="col-sm-3 control-label">Категория:</label>
						<div class="col-sm-4">
							<select class="form-control" id="categoryid" name="categoryid">
								<?php foreach($categorys as $item): ?> 
								<option value="<?php echo $item['ticket_category_id'] ?>"><?php echo $item['ticket_category_name'] ?></option>
								<?php endforeach; ?> 
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="serverid" class="col-sm-3 control-label">Сервер:</label>
						<div class="col-sm-3">
							<select class="form-control" id="serverid" name="serverid">
							  <option value="0">Не выбран</option>
								<?php foreach($servers as $item): ?> 
								<option value="<?php echo $item['server_id'] ?>">gs<?php echo $item['server_id'] ?></option>
								<?php endforeach; ?> 
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="text" class="col-sm-3 control-label">Сообщение:</label>
						<div class="col-sm-7">
							<textarea class="form-control" id="text" name="text" rows="5"></textarea>
						</div>
					</div>
					<div class="form-group">
					  <label for="text" class="col-sm-3 control-label">Каптча:</label>
					  <div class="col-sm-4">
					    <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_client ?>"></div>
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
						url: '/tickets/create/ajax',
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
									setTimeout("redirect('/tickets/view/index/" + data.id + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
				</script>
<?php echo $footer ?>
