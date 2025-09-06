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
					<h1>Изменение слотов сервера</h1>
				</div>
				<form class="form-horizontal" action="#" id="slotsForm" method="POST">
					<h3>Основная информация</h3>
					<div class="form-group">
						<label for="slots" class="col-sm-3 control-label">Количество слотов:</label>
						<div class="col-sm-2">
							<div class="input-group">
								<span class="input-group-btn"><button class="btn btn-default" type="button" onClick="minusSlots()">-</button></span>
								<input type="text" class="form-control" id="slots" name="slots" value="<?php echo $server['server_slots'] ?>">
								<span class="input-group-btn"><button class="btn btn-default" type="button" onClick="plusSlots()">+</button></span>
							</div>
						</div>
					</div>
					<h3>Стоимость</h3>
					<div class="form-group">
						<label for="price" class="col-sm-3 control-label">Итого:</label>
						<div class="col-sm-5">
							<p class="lead" id="price">0.00 руб.</p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
							<button type="submit" class="btn btn-primary">Изменить</button>
						</div>
					</div>
				</form>
				<script>
					$('#slotsForm').ajaxForm({ 
						url: '/servers/slots/ajax/<?php echo $server['server_id'] ?>',
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
									setTimeout("redirect('/servers/control/index/" + <?php echo $server['server_id'] ?> + "')", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
					
					$(document).ready(function() {
						updatePrice();
					});
					
					function updatePrice() {
					  var price = <?php echo $server['game_price'] ?> / 30 * <?php echo $diff->days ?>;
					  var minslots = <?php echo $server['game_min_slots'] ?>;
					  var maxslots = <?php echo $server['game_max_slots'] ?>;
					  var serverslots = <?php echo $server['server_slots'] ?>;
					  var slots = $("#slots").val();
						if(slots < serverslots) {
							if(slots < minslots) {
							  slots = minslots;
							  $("#slots").val(slots);
							}
							price = 0;
						}
						else if(slots > maxslots) {
							slots = maxslots;
							$("#slots").val(slots);
						}
						
						var price = price * (slots-serverslots);
						
						$('#price').text(price.toFixed(2) + ' руб.');
					}
					
					function plusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value+1);
						updatePrice();
					}
					function minusSlots() {
						value = parseInt($('#slots').val());
						$('#slots').val(value-1);
					  updatePrice();
					}
				</script>
<?php echo $footer ?>
