<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * обновляем предоплату, активные варианты товара в другом цвете
 * описание, таблица размеров добавляем не из 1С
 */
function klev_node_json($node, $productname)
{
    $node_json = [];

    if (isset($node->field_jsone_node['und'][0]['value'])) {
        $node_json = json_decode($node->field_jsone_node['und'][0]['value'], true);
    }

    if (isset($productname['color_add'])) {
        if (isset($node_json['color_add'])) {
            unset($node_json['color_add']);
        }
        $node_json['color_add'] = $productname['color_add'];
    } else {
        if (isset($node_json['color_add'])) {
            unset($node_json['color_add']);
        }
    }

    if (isset($productname['Предоплата'])) {
        $node_json['prepayment'] = 'Да';
    } else {
        if (isset($node_json['prepayment'])) {
            unset($node_json['prepayment']);
        }
    }

    $node->field_array_node['und'][0]['value'] = json_encode($node_json, JSON_UNESCAPED_UNICODE);
    return $node;
}