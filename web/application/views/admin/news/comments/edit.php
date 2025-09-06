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
					<h1>Редактирование комментария новости</h1>
				</div>
				<div class="btn-group">
				  <a class="btn btn-danger pull-right" href="/admin/news/comments/edit/delete/<?php echo $comment['news_comment_id'] ?>">Удалить комментарий новости</a>
				</div>
				<form class="form-horizontal" action="#" id="editForm" method="POST">
					<h3>Основная информация</h3>
						<div class="form-group">
							<label for="text" class="col-sm-3 control-label">Текст:</label>
							<div class="col-sm-7">
								<textarea id="text" name="text" class="form-control" rows="5" placeholder="Текст"><?php echo $comment['news_comment_text'] ?></textarea>
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
						url: '/admin/news/comments/edit/ajax/<?php echo $comment['news_comment_id'] ?>',
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
