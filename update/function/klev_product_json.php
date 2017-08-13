<?php
/**
 * @param $new_product
 * @param $product
 * @param $productname
 * @return mixed
 * json c данными для продукта
 */
function klev_product_json($new_product, $product, $productname)
{

    $product_array = [];

    if (isset($product['id'])) {
        $product_array['id'] = trim($product['id']);
    }
    if (isset($product['Штрихкод'])) {
        $product_array['barcode'] = trim($product['Штрихкод']);
    }
    if (isset($product['Склад'])) {
        $product_array['stock'] = $product['Склад'];
    }
    if (isset($product['Количество'])) {
        $product_array['amount'] = trim($product['Количество']);
    }
    if (isset($product['СкладМосква'])) {
        $product_array['stockmoskow'] = trim($product['СкладМосква']);
    }
    if (isset($product['Цена'])) {
        $product_array['price'] = $product['Цена'];
    }
    if (isset($productname['article'])) {
        $product_array['article'] = trim($productname['article']);
    }
    if ((isset($productname['color'])) AND ($productname['color'] != '') AND ($productname['color'] != '-')) {
        $product_array['color'] = trim($productname['color']);
    }
    if (isset($productname['title'])) {
        $product_array['title'] = $productname['title'];
    }
    if (isset($productname['Размер'])) {
        $product_array['size'] = $productname['Размер'];
    }
    if (isset($productname['бренд'])) {
        $product_array['brand'] = $productname['бренд'];
    }
    if (isset($productname['КаталогПервый'])) {
        $product_array['cat1'] = $productname['КаталогПервый'];
    }
    if (isset($productname['КаталогВторой'])) {
        $product_array['cat2'] = $productname['КаталогВторой'];
    }
    if (isset($productname['КаталогТретий'])) {
        $product_array['cat3'] = $productname['КаталогТретий'];
    }
    if (isset($productname['Пол'])) {
        $product_array['sex'] = $productname['Пол'];
    }
    if (isset($productname['КоэфДоставки'])) {
        $product_array['КоэфДоставки'] = $productname['КоэфДоставки'];
    }
    if (isset($new_product->field_images['und'][0]['uri'])) {
        $product_array['images'] = $new_product->field_images['und'][0]['uri'];
    }
    if (isset($productname['Спорт'])) {
        $product_array['Спорт'] = $productname['Спорт'];
    }
    if (isset($productname['Предоплата'])) {
        $product_array['Предоплата'] = 'Да';
    }

    if (count($product_array)) {
        $product->field_jsone_product['und'][0]['value'] = json_encode($product_array, JSON_UNESCAPED_UNICODE);
    }
    return $new_product;

}