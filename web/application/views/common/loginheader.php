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
	<link href="/application/public/css/bootstrap.css" rel="stylesheet">
	
	<script src="/application/public/js/jquery.min.js"></script>
	<script src="/application/public/js/jquery.form.min.js"></script>
	<script src="/application/public/js/bootstrap.min.js"></script>
	<script src="/application/public/js/bootstrap-notify.js"></script>
	<script src="/application/public/js/main.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<style>
		body {
			padding-top: 72px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}
	</style>	
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<a class="navbar-brand" href="#"><?php echo $title ?></a>
		</div>
	</div>
</div>
	<div id="content" class="container">
	<?php if(isset($error)): ?><script>showError("<?php echo $error ?>");</script><?php endif; ?> 
	<?php if(isset($warning)): ?><script>showWarning("<?php echo $warning ?>");</script><?php endif; ?> 
	<?php if(isset($success)): ?><script>showSuccess("<?php echo $success ?>");</script><?php endif; ?>
