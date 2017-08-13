<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * обновляем бренд
 */
function klev_node_brand($node, $productname)
{
    if (isset($node->field_brand['und'])) {
        unset($node->field_brand['und']);
    }

    if (isset($productname['бренд'])) {

        if (!is_string($productname['бренд'])) {
            return $node;
        }

        $term = taxonomy_get_term_by_name($productname['бренд'], 'brand');

        if (sizeof($term) > 0) {
            foreach ($term as $key => $value) {
                if ($term[$key]->vid == 17) {
                    $node->field_brand['und']['0']['tid'] = $key;
                    return $node;
                }
            }
        } else {

            $term = new stdClass();
            $term->name = $productname['бренд'];
            $term->vid = 17;
            taxonomy_term_save($term);
            $node->field_brand['und'][0]['tid'] = $term->tid;
        }
    }

    return $node;
}