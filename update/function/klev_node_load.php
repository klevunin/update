<?php
/**
 * @param $productname
 * @return bool|mixed|null
 * проверка есть ли нода у в системе
 * ключ значения article/color - не удачная модель и пока так работает
 */
function klev_node_load($productname)
{
    /*нет артикула нет ноды*/
    if ($productname['article'] == '') {
        return null;
    }

    /*Термин Артикль-Color*/
    $artcolor = trim($productname['article']) . '/' . trim($productname['color']);

    $nodes_id = db_select('field_data_field_artcolor', 'f')
        ->fields('f', array('entity_id'))
        ->condition('f.field_artcolor_value', $artcolor)
        ->condition('f.delta', 0)
        ->execute()
        ->fetchCol();

    /*проверка есть ли нода*/
    if (isset($nodes_id[0])) {
        /*загружаем ноды*/
        $node = node_load($nodes_id[0]);
        return $node;
    }

    return null;
}