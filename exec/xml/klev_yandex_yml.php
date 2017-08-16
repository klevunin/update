<?php
/**
 * @param $active_node_id
 * @return array
 * достаем настройки скоректированые в ручную для товаров
 */
function klev_yandex_yml($active_node_id)
{
    $yandex_array = [];

    if (count($yandex = db_select('yandex_market_xml', 'f')
        ->fields('f', [
            'nid',
            'bid',
            'cbid',
            'fee',
            'cpa',
            'store',
            'pickup',
            'delivery',
            'available',
            'name',
            'vendor',
            'vendorCode',
            'model',
            'param',
            'sales_notes',
            'description',
            'typePrefix'
        ])
        ->condition('n.nid', $active_node_id)
        ->execute()
        ->fetchAllAssoc('nid')
    )) {
        $yandex_array = $yandex;
    }

    return $yandex_array;
}