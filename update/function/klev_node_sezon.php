<?php
/**
 * @param $node
 * @param $productname
 * @param int $vid
 * @return mixed
 * Сезоность товара
 */
function klev_node_sezon($node, $productname,$vid = 10)
{

    if (isset($node->field_sezon['und'])) {
        unset($node->field_sezon['und']);
    }

    if (isset($productname['Сезонность'])) {

        if (mb_stristr($productname['Сезонность'], 'лето')) {
            $sezon['Лето'] = 'Лето';
        } elseif (mb_stristr($productname['Сезонность'], 'зима')) {
            $sezon['Зима'] = 'Зима';
        }

        $sezon[$productname['Сезонность']] = $productname['Сезонность'];

        $i = 0;
        foreach ($sezon as $item) {

            $term = taxonomy_get_term_by_name($item, 'season');

            if (count($term)) {

                foreach ($term as $key => $value) {
                    if ($term[$key]->vid == $vid) {
                        $node->field_sezon['und'][$i]['tid'] = $key;
                        break;
                    }
                }

            } else {

                $term = new stdClass();
                $term->name = $item;
                $term->vid = 10;
                taxonomy_term_save($term);
                $node->field_sezon['und'][$i]['tid'] = $term->tid;
            }

            $i++;
        }
    }

    return $node;
}