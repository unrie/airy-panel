<ul class="nav nav-tabs">
  <li<?php if($activesection == "servers" && $activeitem == "control"): ?> class="active"<?php endif; ?>><a href="/servers/control/index/<?php echo $server['server_id'] ?>">Управление</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "console"): ?> class="active"<?php endif; ?>><a href="/servers/console/index/<?php echo $server['server_id'] ?>">Консоль</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "stats"): ?> class="active"<?php endif; ?>><a href="/servers/stats/index/<?php echo $server['server_id'] ?>">Статистика</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "ftp"): ?> class="active"<?php endif; ?>><a href="/servers/ftp/index/<?php echo $server['server_id'] ?>">FTP</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "mysql"): ?> class="active"<?php endif; ?>><a href="/servers/mysql/index/<?php echo $server['server_id'] ?>">MySQL</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "edit"): ?> class="active"<?php endif; ?>><a href="/servers/edit/index/<?php echo $server['server_id'] ?>">Редактирование</a></li>
  <li<?php if($activesection == "servers" && $activeitem == "versions"): ?> class="active"<?php endif; ?>><a href="/servers/versions/index/<?php echo $server['server_id'] ?>">Версии</a></li>
  <!--<li class="dropdown">
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">Прочее<b class="caret"></b></a>
    <ul class="dropdown-menu">
      <li><a href="#">Скоро</a></li>
    </ul>
  </li>-->
</ul>
<br>