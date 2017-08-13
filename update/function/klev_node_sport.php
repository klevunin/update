<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * обновляем сопрт
 */
function klev_node_sport($node, $productname)
{
    if (isset($node->field_sport['und'])) {
        unset($node->field_sport['und']);
    }

    if (isset($productname['Спорт'])) {

        $i = 0;
        foreach ($productname['Спорт'] as $key => $value) {

            if (!is_string($value)) {
                continue;
            }

            if ($key == "Бег") {
                $node->field_sport['und'][$i]['tid'] = 2392;
                $i++;
                continue;
            }

            if ($key == "Велоспорт") {
                $node->field_sport['und'][$i]['tid'] = 2391;
                $i++;
                continue;
            }

            if ($key == "Лыжный спорт") {
                $node->field_sport['und'][$i]['tid'] = 2390;
                $i++;
                continue;
            }

            if ($key == "Скандинавская ходьба") {
                $node->field_sport['und'][$i]['tid'] = 2395;
                $i++;
                continue;
            }

            if ($key == "Туризм и активный отдых") {
                $node->field_sport['und'][$i]['tid'] = 2394;
                $i++;
                continue;
            }

            if ($key == "Фитнес") {
                $node->field_sport['und'][$i]['tid'] = 2393;
                $i++;
                continue;
            }

            if ($key == "Флорбол") {
                $node->field_sport['und'][$i]['tid'] = 2396;
                $i++;
                continue;
            }

        }
    }

    return $node;
}