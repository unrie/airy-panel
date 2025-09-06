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
					<h1>Редактирование новости</h1>
				</div>
				<div class="btn-group">
				  <a href="/admin/news/comments/index?newsid=<?php echo $news['news_id'] ?>" class="btn btn-default"><span class="glyphicon glyphicon-comment"></span> Комментарии новости</a>
				  <a class="btn btn-danger pull-right" href="/admin/news/edit/delete/<?php echo $news['news_id'] ?>">Удалить новость</a>
					</div>
				<form class="form-horizontal" action="#" id="editForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="name" class="col-sm-3 control-label">Заголовок:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="name" name="name" placeholder="Введите заголовок" value="<?php echo $news['news_title'] ?>">
						</div>
						</div>
						<div class="form-group">
							<label for="text" class="col-sm-3 control-label">Текст:</label>
							<div class="col-sm-7">
								<textarea id="text" name="text" class="form-control" rows="5" placeholder="Текст"><?php echo $news['news_text'] ?></textarea>
							</div>
						</div>
						<h3>Дополнительная информация</h3>
						<div class="form-group">
						  <label for="comments" class="col-sm-3 control-label">Комментарии:</label>
						  <div class="col-sm-3">
							  <select class="form-control" id="comments" name="comments">
								  <option value="0"<?php if($news['news_comments'] == 0): ?> selected="selected"<?php endif; ?>>Выключены</option>
								  <option value="1"<?php if($news['news_comments'] == 1): ?> selected="selected"<?php endif; ?>>Включены</option>
							  </select>
						  </div>
					  </div>
						<div class="form-group">
						  <label for="type" class="col-sm-3 control-label">Тип:</label>
						  <div class="col-sm-3">
							  <select class="form-control" id="type" name="type">
								  <option value="primary"<?php if($news['news_type'] == 'primary'): ?> selected="selected"<?php endif; ?>>primary</option>
								  <option value="success"<?php if($news['news_type'] == 'success'): ?> selected="selected"<?php endif; ?>>success</option>
								  <option value="danger"<?php if($news['news_type'] == 'danger'): ?> selected="selected"<?php endif; ?>>danger</option>
								  <option value="warning"<?php if($news['news_type'] == 'warning'): ?> selected="selected"<?php endif; ?>>warning</option>
								  <option value="info"<?php if($news['news_type'] == 'info'): ?> selected="selected"<?php endif; ?>>info</option>
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
						url: '/admin/news/edit/ajax/<?php echo $news['news_id'] ?>',
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
