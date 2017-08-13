<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * обновляем пол
 */
function klev_node_sex($node, $productname)
{
    if (isset($node->field_sex['und'])) {
        unset($node->field_sex['und']);
    }

    if (isset($productname['Пол'])) {

        if (!is_string($productname['Пол'])) {
            return $node;
        }

        if ($productname['Пол'] == 'Жен') {
            $node->field_sex['und'][]['tid'] = 2383;
        } elseif ($productname['Пол'] == 'Муж') {
            $node->field_sex['und'][]['tid'] = 2382;
        } elseif ($productname['Пол'] == 'Детск') {
            $node->field_sex['und'][]['tid'] = 2384;
        } elseif ($productname['Пол'] == 'Уни') {
            $node->field_sex['und'][]['tid'] = 2382;
            $node->field_sex['und'][]['tid'] = 2383;
        }
    }

    return $node;
}