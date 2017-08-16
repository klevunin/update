<?php
/**
 * @param $product
 * @param null $product_array
 * @return array
 * подготовка node_array
 */
function klev_node($product, $product_array = null)
{
    $node_array = [];

    if (count($node = db_select('field_data_field_product', 'n')
        ->fields('n', array('entity_id', 'field_product_product_id'))
        ->condition('n.field_product_product_id', $product['id'])
        ->execute()
        ->fetchAllAssoc('field_product_product_id')
    )) {
        foreach ($node as $key => $value) {
            $node_array['mypn'][$value->entity_id]['id'] = $value->entity_id;
            $node_array['mypn'][$value->entity_id]['product'][$key]['id'] = $key;
            if (isset($product['stock'][$key])) {
                $node_array['mypn'][$value->entity_id]['product'][$key]['stock'] = $product['stock'][$key];
            }
            if ($product_array[$key]) {
                $node_array['mypn'][$value->entity_id]['product'][$key]['array'] = $product_array[$key];
            }
            $node_array['node_id'][$value->entity_id] = $value->entity_id;
            $node_array['node_url']['node/' . $value->entity_id] = 'node/' . $value->entity_id;
        }
    }

    return $node_array;
}