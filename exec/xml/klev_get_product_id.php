<?php
/**
 * Достаю id продуктов с положительным остатком
 * @return array
 */
function klev_get_product_id()
{
    $product = [];

    if (count($product_my = db_select('field_data_commerce_stock', 'n')
        ->fields('n', array('entity_id', 'commerce_stock_value'))
        ->condition('n.commerce_stock_value', 0, '>')
         ->range(0, 100)
        ->execute()
        ->fetchAllAssoc('entity_id')
    )) {

        foreach ($product_my as $key => $value) {
            $product['id'][$key] = $key;
            $product['stock'][$key]= $value->commerce_stock_value;
        }

    }

    return $product;
}