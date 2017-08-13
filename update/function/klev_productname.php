<?php
/**
 * @param $row
 * @return array
 * Готовим массив данных $productname
 */
function klev_productname($row)
{

    $productname = [];

    /*смотрим другие цвета*/
    foreach ($row['product']['nomen'] as $key2 => $value2) {
        /*если цвет отличается*/
        if ($key2 != $row['color']) {
            /*если есть в наличие*/
            if ((isset($value2['Количество'])) AND ($value2['Количество'] > 0)) {
                $productname['color_add'][$row['article'] . '/' . $key2] = $row['article'] . '/' . $key2;
            }
        }
    }

    /*есть ли нужный цвет*/
    if (isset($row['product']['nomen'][$row['color']])) {

        if (isset($row['product']['Наименование'])) {
            $productname['title'] = $row['product']['Наименование'];
        }

        if (isset($row['article'])) {
            $productname['article'] = $row['article'];
        }

        if (isset($row['color'])) {
            $productname['color'] = $row['color'];
        }

        if (isset($row['НеПродаватьНаСайте'])) {
            $productname['НеПродаватьНаСайте'] = $row['НеПродаватьНаСайте'];
        }

        if (isset($row['product']['nomen'][$row['color']]['Приоритет'])) {
            $productname['Приоритет'] = $row['product']['nomen'][$row['color']]['Приоритет'];
        }

        if (isset($row['product']['ВидНоменклатуры'])) {
            $productname['бренд'] = $row['product']['ВидНоменклатуры'];
        }

        if (isset($row['product']['Сезонность'])) {
            $productname['Сезонность'] = $row['product']['Сезонность'];
        }

        if (isset($row['product']['Модель'])) {
            $productname['Модель'] = $row['product']['Модель'];
        }

        if (isset($row['product']['КоэфДоставки'])) {
            $productname['КоэфДоставки'] = $row['product']['КоэфДоставки'];
        } else {
            $productname['КоэфДоставки'] = 1;
        }

        if (isset($row['product']['Предоплата'])) {
            $productname['Предоплата'] = $row['product']['Предоплата'];
        }

        if (isset($row['product']['nomen'][$row['color']]['Склад'])) {
            $productname['Склад'] = $row['product']['nomen'][$row['color']]['Склад'];
        }

        if (isset($row['product']['Спорт'])) {
            $productname['Спорт'] = $row['product']['Спорт'];
        }

        if (isset($row['product']['Технология'])) {
            $productname['Технология'] = $row['product']['Технология'];
        }

        if (isset($row['product']['Фильтр'])) {
            $productname['Фильтр'] = $row['product']['Фильтр'];
        }

        if (isset($row['product']['КаталогПервый'])) {
            $productname['КаталогПервый'] = $row['product']['КаталогПервый'];
        }
        if (isset($row['product']['КаталогВторой'])) {
            $productname['КаталогВторой'] = $row['product']['КаталогВторой'];
        }
        if (isset($row['product']['КаталогТретий'])) {
            $productname['КаталогТретий'] = $row['product']['КаталогТретий'];
        }
        if (isset($row['product']['Пол'])) {
            $productname['Пол'] = $row['product']['Пол'];
        }

        if (isset($row['product']['nomen'][$row['color']]['скидка'])) {
            $productname['скидка'] = $row['product']['nomen'][$row['color']]['скидка'];
        }
    }

    return $productname;
}