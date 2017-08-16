<?php
/**
 * @param $product_id
 * @return array
 * достаем массив данных о товаре
 */
function klev_product_json($product_id)
{
    $product_array = [];

    if (count($jsone_product = db_select('field_data_field_jsone_product', 'n')
        ->fields('n', array('entity_id', 'field_jsone_product_value'))
        ->condition('n.entity_id', $product_id)
        ->execute()
        ->fetchAllAssoc('entity_id')))
    {

        foreach ($jsone_product as $key => $value) {
            $product_array[$key] = json_decode($value->field_jsone_product_value['und'][0]['value'],assoc);
        }
    }

    return $product_array;
}