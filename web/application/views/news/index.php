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
          <h1>Новости компании</h1>
        </div>
        <div class="timeline">
          <div class="line text-muted"></div>
             <?php foreach($news as $item): ?>
             <div class="panel panel-<?php echo $item['news_type'] ?>" onClick="redirect('/news/view/index/<?php echo $item['news_id'] ?>')">
               <div class="panel-heading icon">
                 <span class="glyphicon glyphicon-<?php if($item['news_type'] == 'primary'){echo 'plus-sign';}elseif($item['news_type'] == 'success'){echo 'ok-sign';}elseif($item['news_type'] == 'danger'){echo 'exclamation-sign';}elseif($item['news_type'] == 'warning'){echo 'warning-sign';}elseif($item['news_type'] == 'info'){echo 'info-sign';}?>"></i>
               </div>
               <div class="panel-heading">
                 <h2 class="panel-title"><?php echo $item['news_title'] ?></h2>
               </div>
               <div class="panel-body"><?php echo nl2br($item['news_text']) ?></div>
               <div class="panel-footer">
                 <div class="row">
							     <div class="col-md-3 text-muted text-left">
								     <small><span class="glyphicon glyphicon-calendar"></span> <?php echo date("d.m.Y в H:i", strtotime($item['news_date_add'])) ?></small>
							     </div>
							     <div class="col-md-4 text-muted">
								     <small><span class="glyphicon glyphicon-comment"></span></small>
							     </div>
							     <div class="col-md-5 text-muted text-right">
								     <small><span class="glyphicon glyphicon-user"></span> <?php echo $item['user_firstname'] ?> <?php echo $item['user_lastname'] ?></small>
							     </div>
						     </div>
               </div>
             </div>
             <?php endforeach; ?>
             <?php if(empty($news)): ?>
             <div class="panel panel-info panel-outline">
               <div class="panel-heading icon">
                 <span class="glyphicon glyphicon-info-sign"></i>
               </div>
               <div class="panel-body">
                 На данный момент нет новостей.
               </div>
             </div>
             <?php endif; ?>
        </div>
        <?php echo $pagination ?> 
<?php echo $footer ?>
