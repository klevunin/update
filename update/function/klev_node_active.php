<?php
/**
 * @param $node
 * @return mixed
 * включаем/выключаем видимость ноды
 */
function klev_node_active($node)
{

    $node->status = 0;
    $node->promote = 0;
    $node->sticky = 0;

    if ((isset($node->field_product['und']))
        && (count($node->field_product['und']))
        && (isset($node->field_images['und']))
        && (count($node->field_images['und']))) {

        $node->status = 1;
        $node->promote = 1;
        $node->sticky = 1;

    } else {

        $node->status = 0;

        if ((isset($node->field_product['und'])) && (count($node->field_product['und']))) {
            $node->promote = 1;
        }
        if ((isset($node->field_images['und'])) AND (count($node->field_images['und']))) {
            $node->sticky = 1;
        }

    }

    $node->comment = 1;
    return $node;
}