<?php
/**
 * @param $node
 * @param $productname
 * @param $vid
 * @param $vid_name
 * @param $field_name
 * @param int $q
 * @return mixed
 * универсальная функция для добавления термина к ноде
 */
function klev_taxonomy($node, $productname,$name,$vid,$vid_name,$field_name,$q = 0)
{
    if (isset($node->{$field_name}['und'])) {
        unset($node->{$field_name}['und']);
    }

    if (isset($productname[$name])) {

        $i = 0;

        foreach ($productname[$name] as $key => $value) {

            if ($q >0 && $i >= $q) {
                break;
            }

            $term = taxonomy_get_term_by_name($value, $vid_name);

            if (count($term)) {

                foreach ($term as $termkey => $termitem) {
                    if ($termitem == $vid) {
                        $node->{$field_name}['und'][$i]['tid'] = $termkey;
                        $i++;
                        break;
                    }
                }

            } else {

                $term = new stdClass();
                $term->name = $value;
                $term->vid = $vid;
                taxonomy_term_save($term);
                $node->{$field_name}['und'][$i]['tid'] = $term->tid;
                $i++;
            }

        }
    }

    return $node;
}
