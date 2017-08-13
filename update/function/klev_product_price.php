<?php
/**
 * @param $new_product
 * @param $product
 * @return mixed
 * задаем цену продукта
 */
function klev_product_price($new_product, $product)
{
    $price = array('und' => array(0 => array(
        'amount' => $product['ЦенаПродажи'] * 100,
        'currency_code' => commerce_default_currency(),
    )));

    $new_product->commerce_price = $price;
    return $new_product;
}