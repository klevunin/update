<?php
/**
 * @param $new_product
 * @param $productstock
 * @return mixed
 * добавляю остаток, отключаю/включаю товар, добовляю склады магазины
 */
function klev_product_quantity_store($new_product, $productstock)
{

    if ($productstock['СкладМоскваNew'] > 0) {
        $new_product->commerce_stock['und']['0']['value'] = $productstock['СкладМоскваNew'];
        $new_product->status = "1";
    } else {
        $new_product->commerce_stock['und']['0']['value'] = 0;
        $new_product->status = "0";
    }

    if (isset($new_product->field_store)) {
        unset($new_product->field_store['und']);
    }

    $sclad = [];

    foreach ($productstock['Склад'] as $key => $value) {

        if ($key == 'Одинцово_опт') {
            $sclad[32] = 'SKIMiR склад';
            $sclad[6102] = 'Интернет-магазин';
        } elseif ($key == 'Сампо_опт') {
            $sclad[32] = 'SKIMiR склад';
            $sclad[6102] = 'Интернет-магазин';
        } elseif ($key == 'SKIMIR_опт') {
            $sclad[32] = 'SKIMiR склад';
            $sclad[6102] = 'Интернет-магазин';
        } elseif ($key == 'SKIMIR_Москва') {
            $sclad[29] = 'SKIMiR Москва';
            $sclad[6102] = 'Интернет-магазин';
        } elseif ($key == 'SKIMIR_Новосибирск') {
            $sclad[30] = 'SKIMiR Новосибирск';
        } elseif ($key == 'SKIMIR_Сахалин') {
            $sclad[31] = 'SKIMiR Сахалин';
        } elseif ($key == 'ODLO_Снежком') {
            $sclad[25] = 'ODLO Красногорск';
            $sclad[6102] = 'Интернет-магазин';
        } elseif ($key == 'ODLO_Сочи_Галактика') {
            $sclad[20] = 'ODLO Галактика Красная Поляна';
        } elseif ($key == 'ODLO_Сочи_Роза_Хутор') {
            $sclad[24] = 'ODLO Роза Хутор Красная Поляна';
        } elseif ($key == 'ODLO_Сочи_Горки_Молл') {
            $sclad[21] = 'ODLO Горки Молл Красная Поляна';
        } elseif ($key == 'СколковоПроТренер') {
            $sclad[2955] = 'Сколково Про-Тренер';
        } elseif ($key == 'Партнеры') {
            $sclad[6102] = 'Интернет-магазин';
        }
    }

    if (count($sclad)) {
        foreach ($sclad as $key => $value) {
            $new_product->field_store['und'][]['tid'] = $key;
        }
    }

    return $new_product;
}