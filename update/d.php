<?php
/**
 * Update multi shop all
 * BIG DATA
 */
require_once __DIR__ . '/../bootstap.php';

$mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);

$mysqli->query("SET CHARACTER SET 'utf8'");
$mysqli->query("set character_set_client='utf8'");
$mysqli->query("set character_set_results='utf8'");
$mysqli->query("set collation_connection='utf81_general_ci'");
$mysqli->query("SET NAMES utf8");

//Забираем все что есть
$drupal = db_select('field_data_field_artcolor', 'f')
    ->fields('f', array('entity_id', 'field_artcolor_value'))
    ->condition('f.bundle', 'product_display')
    ->execute()
    ->fetchAllAssoc('field_artcolor_value');

$drupal_non_active = db_select('node', 'f')
    ->fields('f', array('nid'))
    ->condition('f.type', 'product_display')
    ->condition('f.status', 0)
    ->execute()
    ->fetchAllAssoc('nid');




$sql = "SELECT `article`, `color`,`quantity` FROM `updaite_site_multi`";
$result = $mysqli->query($sql);

if (isset($result->num_rows)) {
    while ($shop_result = $result->fetch_assoc()) {
        $shop[trim($shop_result['article']) . '/' . trim($shop_result['color'])] = $shop_result['quantity'];
    }
} else {
    exit("Таблица для загрузки пуста. Повторите позже");
}
unset($shop_result);

foreach ($shop as $key => $value) {
    if (isset($drupal[$key])) {
        unset($drupal[$key]);
    }
}

foreach ($drupal as $key => $value) {
    if (isset($drupal_non_active[$value->entity_id])) {
        unset($drupal[$key]);
    }
}


unset($drupal['coupon']);
unset($shop);
unset($drupal_active);

if ($result = $mysqli->query("SHOW COLUMNS FROM updaite_dell_multi")) {
    $mysqli->query("DROP TABLE `updaite_dell_multi`");
    $mysqli->query("CREATE TABLE `updaite_dell_multi` 
(article_color CHAR(36) NOT NULL,
entity_id CHAR(36) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET utf8");
} else {
    $mysqli->query("CREATE TABLE `updaite_dell_multi` 
(article_color CHAR(36) NOT NULL,
entity_id CHAR(36) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET utf8");
}

if (isset($drupal)) {

    foreach ($drupal as $key => $value) {
        $sql = "INSERT INTO `updaite_dell_multi` (`article_color`,`entity_id`) VALUES ('" . $drupal[$key]->field_artcolor_value . "','" . $drupal[$key]->entity_id . "')";
        $result = $mysqli->query($sql);
    }
}
unset($drupal);

$mysqli->close();

exec("/usr/bin/php " . __DIR__ . "/dell.php > /dev/null &");
