<?php

/**
 * Update multi shop all
 * DRUPAL 7
 * BIG DATA
 * Procedural code
 */
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';
require_once __DIR__ . '/../composer/vendor/autoload.php';
require_once __DIR__ . '/function/klev_exit_function.php';
require_once __DIR__ . '/function/klev_productname.php';
require_once __DIR__ . '/function/klev_node_load.php';
require_once __DIR__ . '/function/klev_product_update.php';
require_once __DIR__ . '/function/klev_node_update.php';
require_once __DIR__ . '/function/klev_send_mailchip_product.php';
require_once __DIR__ . '/function/klev_product_price.php';
require_once __DIR__ . '/function/klev_product_json.php';
require_once __DIR__ . '/function/klev_product_quantity_store.php';
require_once __DIR__ . '/function/klev_product_node_add.php';
require_once __DIR__ . '/function/klev_product_images_node.php';
require_once __DIR__ . '/function/klev_node_catalog.php';
require_once __DIR__ . '/function/klev_node_sex.php';
require_once __DIR__ . '/function/klev_node_brand.php';
require_once __DIR__ . '/function/klev_node_sport.php';
require_once __DIR__ . '/function/klev_node_sale.php';
require_once __DIR__ . '/function/klev_node_sezon.php';
require_once __DIR__ . '/function/klev_node_model.php';
require_once __DIR__ . '/function/klev_node_priority.php';
require_once __DIR__ . '/function/klev_do_not_sell_on_the_site.php';
require_once __DIR__ . '/function/klev_node_json.php';
require_once __DIR__ . '/function/klev_node_json_old.php';
require_once __DIR__ . '/function/klev_node_active.php';
require_once __DIR__ . '/function/klev_node_save.php';
require_once __DIR__ . '/function/klev_reIndexSearch.php';
require_once __DIR__ . '/function/klev_taxonomy.php';

$mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);

$mysqli->query("SET CHARACTER SET 'utf8'");
$mysqli->query("set character_set_client='utf8'");
$mysqli->query("set character_set_results='utf8'");
$mysqli->query("set collation_connection='utf81_general_ci'");
$mysqli->query("SET NAMES utf8");

$sql = "SELECT `article_color`,`quantity` FROM `updaite_site_multi` LIMIT 0, 10";
//$sql = "SELECT `article_color`,`quantity` FROM `updaite_site_multi` where `article_color` ='190692-93090'";
$result = $mysqli->query($sql);

if ((isset($result->num_rows)) AND ($result->num_rows != 0)) {
    while ($my_result = $result->fetch_assoc()) {
        $product[$my_result['article_color']] = $my_result['quantity'];
    }
} else {
    klev_exit_function($my_cache_clear);

    $sql = "DROP TABLE `updaite_site_multi`";
    $result = $mysqli->query($sql);

    $dateend = time();
    $sql = "INSERT INTO `one` (`name`,`dateend`) VALUES ('one','" . $dateend . "') ON DUPLICATE KEY UPDATE `dateend`='" . $dateend . "'";
    $result = $mysqli->query($sql);
    $mysqli->close();

    $text = 'Обновление завершенно полностью';
    setEmail($email, 'База обновлена NEW!', $text);
    exit('Обновление завершенно полностью');
}

unset($my_result);


foreach ($product as $key => $value) {

    $sql = "SELECT * FROM `updaite_site_multi` WHERE `article_color` = '" . $key . "'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $result = NULL;
    unset($result);
    unset($sql);

    if (isset($row['product'])) {
        /*готовлю начальные данные*/
        $row['product'] = unserialize($row['product']);
        /*подготавлеваю массив*/
        $productname = klev_productname($row);
        /*пытаюсь загрузить ноду и получить картинку товара*/
        $nodearray = klev_node_load($productname);
        /*обвноялем продукты*/
        $product_id = klev_product_update($row['product']['nomen'][$row['color']], $productname, $nodearray);
        /*обвноялем карточку товара*/
        $node_id = klev_node_update($productname, $product_id, $nodearray);

        if (count($product_id)) {
          /**
           * нужно проверить
           */
         //   klev_send_mailchip_product($row, $productname, $product_id, $node_id, $nodearray);
        }

    }

    unset($row['product']['nomen']);

    /*удаляем строку из базы*/
   $sql = "DELETE FROM `updaite_site_multi` WHERE `article_color` = '" . $key . "'";
   $result = $mysqli->query($sql);
}

$mysqli->close();

//еще раз обходим
print 'ok';
exec("/usr/bin/php " . __DIR__ . "/up.php > /dev/null &");


