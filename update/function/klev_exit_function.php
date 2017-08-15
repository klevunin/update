<?php
/**
 * @param $my_cache_clear
 * Функция запускает скрипты после обмена и чистит кеш каталогов
 */
function klev_exit_function($my_cache_clear)
{
    $drupal_cid = db_select('cache_page', 'c')
        ->fields('c', array('cid'))
        ->condition('cid', '%' . db_like('catalog') . '%', 'LIKE')
        ->execute()
        ->fetchAllAssoc('cid');

    foreach ($drupal_cid as $key1 => $value1) {
        $my_cache_clear[] = $key1;
    }
    unset($drupal_cid);


    $drupal_cid = db_select('cache_page', 'c')
        ->fields('c', array('cid'))
        ->condition('cid', '%' . db_like('/c/') . '%', 'LIKE')
        ->execute()
        ->fetchAllAssoc('cid');

    foreach ($drupal_cid as $key1 => $value1) {
        $my_cache_clear[] = $key1;
    }
    unset($drupal_cid);

    cache_clear_all($my_cache_clear, 'cache_page');

    //каталог
    exec("/usr/bin/php " . __DIR__ . "/../../exec/klev_catalog.php > /dev/null &");
    exec("/usr/bin/php " . __DIR__ . "/../../exec/klev_brand.php > /dev/null &");
    //yml
    //exec("/usr/bin/php " . __DIR__ . "/xml/xml_skimir.php > /dev/null &");
    //карты
    //exec("/usr/bin/php " . __DIR__ . "/new/cart_chek.php > /dev/null &");
}