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
					<h1>Все FAQ</h1>
				</div>
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Название</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($faq as $item): ?> 
						<tr class="<?php if($item['faq_status'] == 0){echo 'danger';} elseif($item['faq_status'] == 1){echo 'success';} ?>" onClick="redirect('/admin/faq/edit/index/<?php echo $item['faq_id'] ?>')" >
							<td>#<?php echo $item['faq_id'] ?></td>
							<td>
							<?php if($item['faq_status'] == 0): ?> 
								<span class="label label-danger">Выключен</span>
							<?php elseif($item['faq_status'] == 1): ?> 
								<span class="label label-success">Включен</span>
							<?php endif; ?> 
							</td>
							<td><?php echo $item['faq_name'] ?></td>
						</tr>
						<?php endforeach; ?> 
						<?php if(empty($faq)): ?> 
						<tr>
							<td colspan="3" class="text-center">На данный момент нет faq.</td>
						<tr>
						<?php endif; ?> 
						<tr>
							<td colspan="3" class="text-center"><a href="/admin/faq/create" class="btn btn-default">Создать FAQ</a></td>
						</tr>
					</tbody>
				</table>
				<?php echo $pagination ?> 
<?php echo $footer ?>
