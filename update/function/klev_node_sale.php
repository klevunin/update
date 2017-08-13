<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * скидки если есть
 */
function klev_node_sale($node, $productname)
{
    if (isset($node->field_sale['und'])) {
        unset($node->field_sale['und']);
    }

    if (isset($productname['скидка'])) {
        $node->field_sale['und']['0']['tid'] = 1730;
    }

    return $node;
}
