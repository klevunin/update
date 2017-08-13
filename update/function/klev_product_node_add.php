<?php
/**
 * @param $node
 * @param $product_id
 * @return mixed
 * добавляем продукты в карточку товара
 */
function klev_product_node_add($node, $product_id)
{
    if (isset($node->field_product['und'])) {
        unset($node->field_product['und']);
    }

    $i = 0;
    foreach ($product_id as $key => $value) {
        if (is_numeric($key)) {
            $node->field_product['und'][$i]['product_id'] = $key;
            $i = $i + 1;
        }
    }

    return $node;
}