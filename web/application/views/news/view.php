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
					<h1>Просмотр новости</h1>
				</div>
    			<div class="panel panel-<?php echo $news['news_type'] ?>">
					<div class="panel-heading">
					  <h2 class="panel-title"><?php echo $news['news_title'] ?></h2>
					</div>
					<div class="panel-body"><?php echo nl2br($news['news_text']) ?></div>
          <div class="panel-footer">
            <div class="row">
							<div class="col-md-3 text-muted text-left">
							  <small><span class="glyphicon glyphicon-calendar"></span> <?php echo date("d.m.Y в H:i", strtotime($news['news_date_add'])) ?></small>
							</div>
							<div class="col-md-4 text-muted">
								<small><span class="glyphicon glyphicon-comment"></span> <?php echo $total ?></small>
							</div>
							<div class="col-md-5 text-muted text-right">
								<small><span class="glyphicon glyphicon-user"></span> <?php echo $news['user_firstname'] ?> <?php echo $news['user_lastname'] ?></small>
							</div>
						</div>
          </div>
				</div>
				<?php foreach($comments as $item): ?> 
				<div class="panel panel-default">
					<div class="panel-body"><?php echo nl2br($item['news_comment_text']) ?></div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-md-6 text-muted text-left">
								<small><span class="glyphicon glyphicon-calendar"></span> <?php echo date("d.m.Y в H:i", strtotime($item['news_comment_date_add'])) ?></small>
							</div>
							<div class="col-md-6 text-muted text-right">
								<small><span class="glyphicon glyphicon-user"></span> <?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></small>
							</div>
						</div>
					</div>
				</div>
				<?php endforeach; ?> 
				<?php if($news['news_comments'] != 0): ?> 
				<h2>Отправить комментарий</h2>
				<form class="form-horizontal" id="sendForm" action="#" method="POST">
					<div class="form-group">
						<label for="text" class="col-sm-3 control-label">Текст:</label>
						<div class="col-sm-7">
							<textarea class="form-control" id="text" name="text" rows="3" placeholder="Введите текст комментария"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Отправить</button>
						</div>
					</div>
				</form>
				<script>
					$('#sendForm').ajaxForm({ 
						url: '/news/view/ajax/<?php echo $news['news_id'] ?>',
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
									$('#text').val('');
									setTimeout("reload()", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
				</script>
				<?php endif; ?>
<?php echo $footer ?>
