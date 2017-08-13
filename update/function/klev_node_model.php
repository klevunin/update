<?php
/**
 * @param $node
 * @param $productname
 * @param int $vid
 * @return mixed
 * Обновляю модель
 */
function klev_node_model($node,$productname,$vid = 33)
{

    if (isset($node->field_model['und'])) {
        unset($node->field_model['und']);
    }

    if (isset($productname['Модель'])) {

        if (!is_string($productname['Модель'])) {
            return $node;
        }

        $term = taxonomy_get_term_by_name($productname['Модель'], 'model');

        if (count($term)) {
            foreach ($term as $key => $value) {
                if ($term[$key]->vid == $vid) {
                    $node->field_model['und']['0']['tid'] = $key;
                    return $node;
                }
            }
        } else {

            $term = new stdClass();
            $term->name = $productname['Модель'];
            $term->vid = $vid;
            taxonomy_term_save($term);
            $node->field_model['und'][0]['tid'] = $term->tid;
        }
    }

    return $node;
}