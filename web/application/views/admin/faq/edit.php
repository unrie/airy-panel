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
					<h1>Редактирование FAQ</h1>
				</div>
				<div class="btn-group">
				  <a class="btn btn-danger pull-right" href="/admin/faq/edit/delete/<?php echo $faq['faq_id'] ?>">Удалить FAQ</a>
				</div>
				<form class="form-horizontal" action="#" id="editForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label">Название:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите название" value="<?php echo $faq['faq_name'] ?>">
						</div>
						</div>
						<div class="form-group">
							<label for="text" class="col-sm-3 control-label">Текст:</label>
							<div class="col-sm-7">
								<textarea id="text" name="text" class="form-control" rows="5" placeholder="Текст"><?php echo $faq['faq_text'] ?></textarea>
							</div>
						</div>
						<h3>Дополнительная информация</h3>
						<div class="form-group">
						  <label for="status" class="col-sm-3 control-label">Статус:</label>
						  <div class="col-sm-3">
							  <select class="form-control" id="status" name="status">
								  <option value="0"<?php if($faq['faq_status'] == 0): ?> selected="selected"<?php endif; ?>>Выключен</option>
								  <option value="1"<?php if($faq['faq_status'] == 1): ?> selected="selected"<?php endif; ?>>Включен</option>
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
						url: '/admin/faq/edit/ajax/<?php echo $faq['faq_id'] ?>',
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
				</script>
<?php echo $footer ?>
