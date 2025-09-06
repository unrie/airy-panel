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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $description ?>">
	<meta name="keywords" content="<?php echo $keywords ?>">
	
	<title><?php echo $title ?> | Панель управления</title>
    
  <link href="/application/public/css/main.css" rel="stylesheet">
  <?php if($user_theme == 0): ?>
	<link href="/application/public/css/bootstrap.css" rel="stylesheet">
	<?php elseif($user_theme == 1): ?>
	<link href="/application/public/css/bootstrap-dark.css" rel="stylesheet">
	<?php endif; ?>
	<link href="/application/public/css/timeline.css" rel="stylesheet">

	<script src="/application/public/js/jquery.min.js"></script>
	<script src="/application/public/js/jquery.form.min.js"></script>
	<script src="/application/public/js/jquery.flot.min.js"></script>
	<script src="/application/public/js/jquery.flot.time.min.js"></script>
	<script src="/application/public/js/bootstrap.min.js"></script>
	<script src="/application/public/js/bootstrap-notify.js"></script>
	<script src="/application/public/js/main.js"></script>
	<script src="/application/public/js/clipboard.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script type="text/javascript" src="https://vk.com/js/api/openapi.js?162"></script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#"><?php echo $title ?></a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li<?php if($activesection == "main"): ?> class="active"<?php endif; ?>><a href="/main/index">Главная</a></li>
					<li<?php if($activesection == "servers"): ?> class="active"<?php endif; ?>><a href="/servers/index">Серверы</a></li>
					<li<?php if($activesection == "tickets"): ?> class="active"<?php endif; ?>><a href="/tickets/index">Поддержка</a></li>
					<li<?php if($activesection == "news"): ?> class="active"<?php endif; ?>><a href="/news/index">Новости</a></li>
					<li<?php if($activesection == "monitoring"): ?> class="active"<?php endif; ?>><a href="/monitoring/index">Мониторинг</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
				  <li><a href="/account/pay"><span class="glyphicon glyphicon-usd"></span> <?php echo $user_balance ?> руб.</a></li>
				  <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?php echo $user_firstname ?> <?php echo $user_lastname ?><b class="caret"></b></a>
						<ul class="dropdown-menu">
						  <li><a href="/account/edit">Настройки</a></li>
						  <li class="divider"></li>
						  <li><a href="/account/logout">Выход</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col-md-3">
    			<?php if($user_access_level >= 2): ?>
    			<div class="text-center">
					<div class="btn-group btn-group-sm">
						<button type="button" class="btn btn-default<?php if($activesection != "admin"): ?> active<?php endif; ?>" id="userNavModeBtn" onClick="setNavMode('user')">Пользователь</button>
						<button type="button" class="btn btn-default<?php if($activesection == "admin"): ?> active<?php endif; ?>" id="administratorNavModeBtn" onClick="setNavMode('administrator')">Администратор<?php if($admintickets): ?> <span class="badge badge-secondary"><?php echo $admintickets ?></span><?php endif; ?></button>
					</div>
    			</div>
    			<?php endif; ?> 
    			<div id="userNavMode"<?php if($activesection == "admin"): ?> style="display: none;"<?php endif; ?>>
					<h3>Серверы</h3>
					<div class="list-group">
						<a href="/servers/index" class="list-group-item<?php if($activesection == "servers" && $activeitem == "index"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-hdd"></span> Мои серверы</a>
						<a href="/servers/order" class="list-group-item<?php if($activesection == "servers" && $activeitem == "order"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-plus"></span> Заказать сервер</a>
					</div>
					<h3>Поддержка</h3>
					<div class="list-group">
						<a href="/tickets/index" class="list-group-item<?php if($activesection == "tickets" && $activeitem == "index"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-headphones"></span> Мои запросы</a>
						<a href="/tickets/create" class="list-group-item<?php if($activesection == "tickets" && $activeitem == "create"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-plus"></span> Создать запрос</a>
						<a href="/faq/index" class="list-group-item<?php if($activesection == "faq" && $activeitem == "index"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-book"></span> FAQ</a>
					</div>
					<h3>Аккаунт</h3>
					<div class="list-group">
						<a href="/account/pay" class="list-group-item<?php if($activesection == "account" && $activeitem == "pay"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-usd"></span> Пополнение баланса</a>
						<a href="/account/invoices" class="list-group-item<?php if($activesection == "account" && $activeitem == "invoices"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-list"></span> Счета</a>
						<a href="/account/authlogs" class="list-group-item<?php if($activesection == "account" && $activeitem == "authlogs"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-sort"></span> Логи авторизаций</a>
						<a href="/account/edit" class="list-group-item<?php if($activesection == "account" && $activeitem == "edit"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-wrench"></span> Настройки</a>
						<a href="/account/logout" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> Выход</a>
					</div>
				</div>
				<?php if($user_access_level >= 2): ?>
    			<div id="administratorNavMode"<?php if($activesection != "admin"): ?> style="display: none;"<?php endif; ?>>
    				<?php if($user_access_level >= 2): ?> 
					<h3>Поддержка</h3>
					<div class="list-group">
						<a href="/admin/servers/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "servers"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-hdd"></span> Все серверы</a>
						<a href="/admin/tickets/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "tickets"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-headphones"></span> Все запросы<?php if($admintickets): ?><span class="badge badge-secondary"><?php echo $admintickets ?></span><?php endif; ?></a>
						<a href="/admin/users/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "users"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-user"></span> Все пользователи</a>
						<a href="/admin/invoices/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "invoices"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-list"></span> Все счета</a>
						<a href="/admin/authlogs/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "authlogs"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-sort"></span> Все логи авторизаций</a>
					</div>
					<?php endif; ?> 
					<?php if($user_access_level >= 3): ?> 
					<h3>Управление</h3>
					<div class="list-group">
					  <a href="/admin/games/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "games"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-tower"></span> Все игры</a>
					  <a href="/admin/locations/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "locations"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-globe"></span> Все локации</a>
						<a href="/admin/news/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "news"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-list-alt"></span> Все новости</a>
						<a href="/admin/news/comments/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "newscomments"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-comment"></span> Все комментарии новостей</a>
						<a href="/admin/tickets/categorys/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "ticketscategorys"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-align-justify"></span> Все категории запросов</a>
						<a href="/admin/faq/index" class="list-group-item<?php if($activesection == "admin" && $activeitem == "faq"): ?> active<?php endif; ?>"><span class="glyphicon glyphicon-book"></span> Все FAQ</a>
					</div>
					<?php endif; ?> 
				</div>
				<?php endif; ?>
    		</div>
    		<div id="content" class="col-md-9">
				<?php if(isset($error)): ?><script>showError("<?php echo $error ?>");</script><?php endif; ?> 
		    <?php if(isset($warning)): ?><script>showWarning("<?php echo $warning ?>");</script><?php endif; ?> 
		    <?php if(isset($success)): ?><script>showSuccess("<?php echo $success ?>");</script><?php endif; ?> 
