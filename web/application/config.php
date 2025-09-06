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
$config = array(
	// Название компании.
	// Пример: ExampleHost
	'title'			=>		'',
	
	// Описание компании (meta description).
	// Пример: Game Hosting ExampleHost
	'description'	=>		'',
	
	// Ключевые слова (meta keywords).
	// Пример: game hosting, game servers
	'keywords'		=>		'',
	
	// URL панели управления.
	// Обратите внимание на то, что панель управления должна располагаться в корне (под)домена.
	// http://example.com/, http://cp.example.com/, http://panel.example.com/ - правильно.
	// http://example.com/panel/ - неправильно.
	'url'			=>		'',
	
	// Токен.
	// Используется для запуска скриптов из Cron`а.
	'token'			=>		'',
	
	// Тип СУБД.
	// По умолчанию поддерживается только СУБД MySQL (mysql/mysqli).
	'db_type'		=>		'mysqli',
	
	// Хост БД.
	// Пример: localhost, 127.0.0.1, db.example.com и пр.
	'db_hostname'	=>		'localhost',
	
	// Имя пользователя СУБД.
	'db_username'	=>		'root',
	
	// Пароль пользователя СУБД.
	'db_password'	=>		'',
	
	// Название БД.
	'db_database'	=>		'',
	
	// E-Mail отправителя.
	// Пример: support@example.com, noreply@example.com
	'mail_from'		=>		'',
	
	// Имя отправителя.
	// Пример: ExampleHost Support
	'mail_sender'	=>		'',
	
	// URL мерчанта.
	// Для активированных аккаунтов - https://merchant.roboxchange.com
	// Для неактивированных аккаунтов - http://test.robokassa.ru/Index.aspx
	'rk_server'		=>		'http://www.free-kassa.ru/merchant/cash.php',
	
	// Логин в системе ROBOKASSA.
	'rk_login'		=>		'',
	
	// Пароль №1 в системе ROBOKASSA.
	'rk_password1'	=>		'',
	
	// Пароль №2 в системе ROBOKASSA.
	'rk_password2'	=>		'',
	
	// Ключ для клиентской части reCAPTCHA.
	'recaptcha_client'	=>		'',
	
	// Ключ для серверной части reCAPTCHA.
	'recaptcha_server'	=>		''
);
?>
