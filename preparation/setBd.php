<?php
ini_set("memory_limit", "512M");
$mem0 = memory_get_usage();
$start = microtime(true);
set_time_limit(0);
/* подключаем обработку XML 1С */
require __DIR__ . '/import.php';
/* расчет процентов скидок и варинты доставки */
require __DIR__ .'/price.php';
/* входим в бд */
require __DIR__ .'/../config.php';


$mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);
$mysqli->query("SET CHARACTER SET 'utf8'");
$mysqli->query("set character_set_client='utf8'");
$mysqli->query("set character_set_results='utf8'");
$mysqli->query("set collation_connection='utf81_general_ci'");
$mysqli->query("SET NAMES utf8");


/* проверка соединения */
if ($mysqli->connect_errno) {
    printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
    setEmail($email, 'UPDATE connect_error - ' . sizeof($nomen) . '!', $mysqli->connect_error);
    exit();
}


if ($result = $mysqli->query("SHOW COLUMNS FROM updaite_site_multi")) {

    $mysqli->query("DROP TABLE `updaite_site_multi`");

    $mysqli->query("CREATE TABLE `updaite_site_multi` 
(article_color CHAR(100) NOT NULL,
PRIMARY KEY (article_color),
article	TEXT,
color TEXT,
product longtext,
quantity INT(10)) ENGINE=InnoDB DEFAULT CHARSET utf8");

} else {

    $mysqli->query("CREATE TABLE `updaite_site_multi` 
(article_color CHAR(100) NOT NULL,
PRIMARY KEY (article_color),
article	TEXT,
color TEXT,
product longtext,
quantity INT(10)) ENGINE=InnoDB DEFAULT CHARSET utf8");

}


/* Записываем в БД */
foreach ($nomen as $key => $value) {
    foreach ($nomen[$key]['nomen'] as $key2 => $value2) {

        if ($my_status['СодержитТолькоИзменения'] == 'false') {
            if ((!isset($nomen[$key]['nomen'][$key2]['Количество'])) OR ($nomen[$key]['nomen'][$key2]['Количество'] < 1)) {
                continue;
            }
        }

        if ((!isset($nomen[$key]['скидка'])) OR ($nomen[$key]['скидка'] < 0)) {
            $nomen[$key]['скидка'] = 0;
        }

        $product = serialize($nomen[$key]);


        $sql = "INSERT INTO `updaite_site_multi` (`article_color`,`article`,`color`,`product`,`quantity`) VALUES ('" . $nomen[$key]['Артикул'] . "-" . $key2 . "','" . $nomen[$key]['Артикул'] . "','" . $key2 . "','" . $product . "','" . $nomen[$key]['nomen'][$key2]['Количество'] . "')";
        $result = $mysqli->query($sql);

        unset($product);

    }

}


if ($result = $mysqli->query("SHOW COLUMNS FROM updaite_catalog")) {

    $sql = "SELECT `id`,`catalog` FROM `updaite_catalog` LIMIT 0, 20";
    $result = $mysqli->query($sql);


    if ((isset($result->num_rows)) AND ($result->num_rows != 0)) {
        while ($my_result = $result->fetch_assoc()) {
            $catalog = unserialize($my_result['catalog']);
        }
    } else {

        $catalog = array();
    }

    foreach ($mysupercat as $key => $value) {
        $catalog[$key] = $value;
    }

}

if (isset($catalog_array)) {

    $catalog_array = serialize($catalog);

    if ($result = $mysqli->query("SHOW COLUMNS FROM updaite_catalog")) {

        $mysqli->query("DROP TABLE `updaite_catalog`");

        $mysqli->query("CREATE TABLE `updaite_catalog`
         (id CHAR(100) NOT NULL,
          PRIMARY KEY (id),
          catalog	TEXT) ENGINE=InnoDB DEFAULT CHARSET utf8");

    } else {

        $mysqli->query("CREATE TABLE `updaite_catalog`
         (id CHAR(100) NOT NULL,
          PRIMARY KEY (id),
          catalog	TEXT) ENGINE=InnoDB DEFAULT CHARSET utf8");

    }

    $sql = "INSERT INTO `updaite_catalog` (`id`,`catalog`) VALUES ('1','" . $catalog_array . "')";

    unset($catalog_array);

    $result = $mysqli->query($sql);

}

$mysqli->close();
$text='';
if ($my_status['СодержитТолькоИзменения'] == 'false') {
    $text .= 'Идет полное обновление!' . PHP_EOL;
    exec("/usr/bin/php $update_d_pwd > /dev/null &");
} else {
    $text .= 'Идет обновление только по изменению!' . PHP_EOL;
    exec("/usr/bin/php $update_up_pwd > /dev/null &");
}


$text .= 'В BD массив размером ' . sizeof($nomen) . PHP_EOL;
$text .= 'Script ALL memori: ' . (memory_get_usage() - $mem0 - sizeof($mem0)) . ' bytes' . PHP_EOL;
$text .= 'Script ALL time: ' . (microtime(true) - $start) . ' bytes' . PHP_EOL;


setEmail($email, 'UPDATE SHOP - ' . sizeof($nomen) . '!', $text);


