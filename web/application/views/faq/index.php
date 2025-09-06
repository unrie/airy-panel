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
					<h1>FAQ</h1>
				</div>
        <div class="panel-group" id="accordion">
          <?php foreach($faq as $item): ?>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $item['faq_id'] ?>">
                <?php echo $item['faq_name'] ?></a>
              </h4>
            </div>
            <div id="collapse<?php echo $item['faq_id'] ?>" class="panel-collapse collapse">
              <div class="panel-body"><?php echo nl2br($item['faq_text']) ?></div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php echo $pagination ?>
<?php echo $footer ?>
