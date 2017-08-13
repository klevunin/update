<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * убираем с продажи если явно указано не продовать
 * фильтр для бренда одло
 */
function klev_do_not_sell_on_the_site($node, $productname)
{
    if ((isset($productname['НеПродаватьНаСайте'])) && ($productname['НеПродаватьНаСайте'] == 'Да')) {
        $node->field_odlo_yes['und'][0]['value'] = 0;
        $node->field_skimir_yes['und'][0]['value'] = 0;
    } else {
        if ($productname['бренд'] != 'ODLO') {
            $node->field_odlo_yes['und'][0]['value'] = 0;
        }
    }

    return $node;
}