<?php
/**
 * @param $new_product
 * @param $imagesnode
 * @return mixed
 * просто берем массив с описанием кратинки от ноды и присваеваем его продукту
 */
function klev_product_images_node($new_product, $imagesnode)
{
    if (isset($new_product->field_images['und'])) {
        unset($new_product->field_images['und']);
    }

    $new_product->field_images['und'][0] = $imagesnode;
    return $new_product;
}