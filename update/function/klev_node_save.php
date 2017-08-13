<?php
/**
 * @param $node
 * @param $productname
 * @param $a
 * сохраняем обновленную или новую краточку товара
 */
function klev_node_save($node, $productname, $a)
{

    if ($a == 1) {
        /*новая карточка кеш обновлять не нужно*/
        if ($node = node_submit($node)) {
            node_save($node);
        }
    } else {

        node_save($node);

        $nodes_url = db_select('url_alias', 'f')
            ->fields('f', array('alias'))
            ->condition('f.source', 'node/' . $node->nid)
            ->execute()
            ->fetchCol();

        if ($nodes_url[0]) {
            $my_cache_clear_node[] = 'https://www.skimir.ru/' . $nodes_url[0];
            $my_cache_clear_node[] = 'https://www.odlo.ru/' . $nodes_url[0];
            cache_clear_all($my_cache_clear_node, 'cache_page');
        }
    }
}