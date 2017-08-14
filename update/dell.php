<?php
/**
 * Update multi shop all
 * BIG DATA
 */
require_once __DIR__ . '/../bootstap.php';
require_once __DIR__ . '/../composer/vendor/autoload.php';


$mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);

$mysqli->query("SET CHARACTER SET 'utf8'");
$mysqli->query("set character_set_client='utf8'");
$mysqli->query("set character_set_results='utf8'");
$mysqli->query("set collation_connection='utf81_general_ci'");
$mysqli->query("SET NAMES utf8");


$sql = "SELECT `article_color`,`entity_id` FROM `updaite_dell_multi` LIMIT 0, 20";
$result = $mysqli->query($sql);

if ((isset($result->num_rows)) AND ($result->num_rows != 0)) {
    while ($shop_result = $result->fetch_assoc()) {
        $shop[$shop_result['article_color']] = $shop_result['entity_id'];
    }
} else {

    $sql = "DROP TABLE `updaite_dell_multi`";
    $result = $mysqli->query($sql);
    $mysqli->close();

    $text = 'Изменен статус на не активно полностью';
    setEmail($email, 'Изменен статус на не активно завершенно!', $text);

    //поехали обновлять SKIMIR
    //exec("/usr/bin/php ".__DIR__."/up.php > /dev/null &");

    exit();

}

unset($shop_result);


foreach ($shop as $key => $value) {

    product_example_node_dell($value);

    $sql = "DELETE FROM `updaite_dell_multi` WHERE `article_color` = '" . $key . "'";
    $result = $mysqli->query($sql);
    gc_collect_cycles();
}

$mysqli->close();

function product_example_node_dell($entity_id)
{
    $mailchipdell=0;
    $node = node_load($entity_id);
    if (isset($node->nid)) {

        if ($node->status = 1) {
        //    dell_product_mailchimp($entity_id);
        }

        $node->status = 0; // Опуликовано (1) или нет (0)

        if (sizeof($node->field_product['und']) > 0) {
            foreach ($node->field_product['und'] as $i => $value222) {

                $new_product = commerce_product_load($node->field_product['und'][$i]['product_id']);

                /*добавляем склады*/
                if (isset($new_product->field_store)) {
                    unset($new_product->field_store['und']);
                }
                $product_array = json_decode($new_product->field_jsone_product['und']['0']['value'], assoc);

                unset($product_array['stock']);

                $new_product->field_jsone_product['und']['0']['value'] = json_encode($product_array, JSON_UNESCAPED_UNICODE);
                $new_product->status = 0;


                if (isset($new_product->product_id)) {
                    commerce_product_save($new_product);
                } else {
                    $text='Нет id продукта при изменение статуса на не активно - '. $entity_id.' - '. $node->field_product['und'][$i]['product_id'];
                    setEmail($email, 'Нет id продукта - ' . $entity_id . '!', $text);
                }
                unset($new_product);

            }
            unset($node->field_product['und']);
        }


        $nodes_url = db_select('url_alias', 'f')
            ->fields('f', array('alias'))
            ->condition('f.source', 'node/' . $node->nid)
            ->execute()
            ->fetchCol();

        if ($nodes_url[0]) {
            $my_cache_clear[] = 'https://www.skimir.ru/' . $nodes_url[0];
            $my_cache_clear[] = 'http://shop.odlo.ru/' . $nodes_url[0];
            $my_cache_clear[] = 'https://www.odlo.ru/' . $nodes_url[0];
        }

        node_save($node);

        cache_clear_all($my_cache_clear, 'cache_page');

        exec("/usr/bin/php ".__DIR__."/reindex/dev.skimir.ru.php $entity_id > /dev/null &");


    } else {
        $text='Не могу сохранить node для удаления - '. $entity_id;
        setEmail($email, 'Нет NODE для удаления - ' . $entity_id . '!', $text);
    }
}

//удялем продукт с mailchimp
//нужно проверить работу атозагрузки.
function dell_product_mailchimp($nid)
{
    $data['id'] = $nid;

    $DeleteProductsPrepare = new \Klev\MailchimpEC\Prepare\DeleteProductsPrepare();
    $data_DeleteProducts = $DeleteProductsPrepare->prepareRequest($data);

    if ($data_DeleteProducts) {
        $DeleteProductsRequest = new \Klev\MailchimpEC\Request\DeleteProductsRequest();
        $result = $DeleteProductsRequest->request($data_DeleteProducts);
    }
}

exec("/usr/bin/php ".__DIR__."/dell.php > /dev/null &");





