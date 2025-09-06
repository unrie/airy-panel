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
					<h1>Консоль сервера</h1>
				</div>
				<?php include 'tabs.php'; ?>
				<form class="form-horizontal" action="#" id="consoleForm" method="POST">
					<div class="form-group">
					  <div class="col-sm-12">
						  <textarea class="form-control" id="console" name="console" rows="15" disabled>
						  <?php
						  for ($i = max(0, count($screenlog)-101); $i < count($screenlog); $i++) {
                echo $screenlog[$i];
              }
						  ?>
						  </textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
						  <div class="input-group">
						    <span class="input-group-btn"><a href="#cmdlist" class="btn btn-default" data-toggle="modal"><span class="glyphicon glyphicon-list-alt"></span></a></span>
							  <input type="text" class="form-control" id="command" name="command" placeholder="Введите команду сервера">
							  <span class="input-group-btn"><button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-send"></span></button></span>
						  </div>
						</div>
					</div>
					<div id="cmdlist" class="modal fade">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h4 class="modal-title">Список доступных команд сервера</h4>
                </div>
                <div class="modal-body">
                  <?php if($server['game_query'] == 'samp'): ?>
                  <code>cmdlist</code> - Показать список RCON команд.<br>
						      <code>varlist</code> - Посмотреть список текущих настроек.<br>
						      <code>kick [ID]</code> - Кикнуть пользователя по его ID (Пример: kick 3).<br>
						      <code>ban [ID]</code> - Забанить пользователя по его ID (Пример: ban 3).<br>
						      <code>banip [IP]</code> - Забанить IP (Пример: banip 127.0.0.1).<br>
						      <code>unbanip [IP]</code> - Разбанить IP (Пример: unbanip 127.0.0.1).<br>
						      <code>reloadbans</code> - Перезагрузить samp.ban, в котором содержатся забаненные IP.<br>
						      <code>reloadlog</code> - Очистить лог сервера.<br>
						      <code>exec [имя файла]</code> - Открыть файл .cfg (Пример: exec blah.cfg).<br>
						      <code>say [текст]</code> - Сказать в общий чат от лица админа (Пример: say Hello).<br>
						      <code>players</code> - Показать всех игроков на сервере с их именами, ip и пингом.<br>
						      <code>gravity</code> - Изменить гравитацию на сервере - (Пример: gravity 0.008).<br>
						      <code>weather [ID]</code> - Изменить погоду на сервере (Пример: weather 2).<br>
						      <code>worldtime [время]</code> - Изменить время на сервере (Пример: worldtime 2).<br>
						      <code>maxplayers</code> - Изменить макс. количество мест на сервере.<br>
						      <code>timestamp</code> - Установить часовой пояс.<br>
						      <code>plugins</code> - Посмотреть список всех установленных плагинов.<br>
						      <code>filterscripts</code> - Посмотреть список всех установленных фильтрскриптов.<br>
						      <code>loadfs [название]</code> - Загрузить фильтрскрипт.<br>
						      <code>unloadfs [название]</code> - Выгрузить фильтрскрипт.<br>
						      <code>reloadfs [название]</code> - Перезагрузить фильтрскрипт.<br>
						      <code>password [пароль]</code> - Установить пароль на сервере.<br>
						      <code>changemode [название]</code> - Изменить режим игры на сервере на заданный.<br>
						      <code>gmx</code> - Рестарт сервера.<br>
						      <code>hostname [название]</code> - Изменить название сервера.<br>
						      <code>gamemodetext [название]</code> - Изменить название мода.<br>
						      <code>mapname [название]</code> - Изменить название карты.<br>
						      <code>gamemode [1-15]</code> - Установить порядок гэйм-модов.<br>
						      <code>instagib [bool]</code> - Включить функцию убийства с одной пули (1 или 0).<br>
						      <code>lanmode [bool]</code> - Установить LAN (1 или 0).<br>
						      <code>version</code> - Посмотреть версию сервера.<br>
						      <code>weburl [урл]</code> - Установить url сайта на сервере.<br>
						      
						      <?php elseif($server['game_query'] == 'mine'): ?>
						      <code>help</code> или <code>?</code> - Раскрывает список доступных команд в окне лога.<br>
                  <code>kick [player]</code> - Исключает определенного игрока с сервера.<br>
                  <code>ban [player]</code> - Блокирует никнейм игрока на данном сервере.<br>
                  <code>pardon [player]</code> - Разблокирование ранее заблокированного игрока.<br>
                  <code>ban-ip [ip]</code> - Блокировка IP-адреса. Любой игрок с этим адресом больше не сможет подключиться к данному серверу. Учитывайте, что у многих динамический IP.<br>
                  <code>pardon-ip [ip]</code> - Исключение ранее заблокированного IP-адреса из списка блокировок.<br>
                  <code>op [player]</code> - Делает указанного игрока оператором (Админом) сервера.<br>
                  <code>deop [player]</code> - Исключает указанного игрока из категории операторов (Админов) сервера.<br>
                  <code>tp [player1] [player2]</code> - Телепортирует игрока player1 к игроку player2.<br>
                  <code>give [player] [id] [num]</code> - Даёт указанному игроку определенное количество указанных по ID ресурсов.<br>
                  <code>stop</code> - Сохранение карты и остановка сервера.<br>
                  <code>save-all</code> - Сохраняет карту сервера.<br>
                  <code>save-off</code> - Отключает автоматическое сохранение карты (полезно при использовании специальных скриптов по созданию резервных копий карты сервера).<br>
                  <code>save-on</code> - Включает автосохранение.<br>
                  <code>list</code> - Выводит список подключенных в данный момент к серверу игроков.<br>
                  <code>say [message]</code> - Показывает сообщение всем игрокам на сервере особым цветом.<br>
                  <code>whitelist [on/off]</code> - Включает или выключает вайтлист. При включенном состоянии на сервер могут попасть только игроки, находящиеся в данном списке. В выключенном состоянии на сервер может попасть любой желающий.<br>
                  <code>whitelist [add/remove] [player]</code> - Добавить или убрать ник игрока из вайтлиста.<br>
                  <code>whitelist list</code> - Выводит список игроков, находящихся в вайтлисте.<br>
                  <code>whitelist reload</code> - Перезагружает вайтлист из файла.<br>
                  <code>time [add/set] [amount]</code> - Установка игрового времени. Число может быть введено в промежутке от 0 до 24000. Например, 0 — рассвет, 12000 - закат, 18000 — полночь.<br>
                  <code>xp [player] [amount]</code> - Дать игроку какое то количества опыта<br>
                  <code>xpset [player] [amount]</code> - Даёт игроку player указанное количество сфер опыта (до 5000). Отрицательное число уменьшит опыт уровня, но не понизит сам уровень.<br>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
				</form>
				<script>
					$('#consoleForm').ajaxForm({ 
						url: '/admin/servers/console/ajax/<?php echo $server['server_id'] ?>',
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
									setTimeout("reload()", 1500);
									break;
							}
						},
						beforeSubmit: function(arr, $form, options) {
							$('button[type=submit]').prop('disabled', true);
						}
					});
          $("#console").scrollTop($("#console").prop('scrollHeight'));
				</script>
<?php echo $footer ?>
