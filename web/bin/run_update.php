<?php
print 'Обмен запущен!';
//require (__DIR__.'/../preparation/setBd.php');
exec("/usr/bin/php /home/deploy/service/update/preparation/setBd.php > /dev/null &");