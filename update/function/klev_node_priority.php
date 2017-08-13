<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * уставновка приоритета карточки товара
 */
function klev_node_priority($node, $productname)
{

    if (is_numeric($productname['Приоритет']) && $productname['Приоритет'] >= 0) {
        $node->field_sales_priority['und'][0]['value'] = $productname['Приоритет'];
    } else {
        $node->field_sales_priority['und'][0]['value'] = 0;
    }

    return $node;

}