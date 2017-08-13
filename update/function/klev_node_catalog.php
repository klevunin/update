<?php
/**
 * @param $node
 * @param $productname
 * @param int $vid - номер словаря каталога
 * @return mixed
 * добаляем главный каталог
 */

/*обновляем каталоги 1С ноды*/
function klev_node_catalog($node, $productname, $vid = 35)
{

    if (isset($node->field_c['und'])) {
        unset($node->field_c['und']);
    }

    if ((isset($productname['КаталогПервый'])) AND (isset($productname['КаталогВторой']))) {

        foreach ($productname['КаталогПервый'] as $desc1 => $item1) {

            if (!is_string($item1)) {
                continue;
            }

            $tid_parent = 0;

            $term_tid = db_select('taxonomy_term_data', 'n')
                ->fields('n', array('tid', 'vid', 'name', 'description'))
                ->condition('description', $desc1)
                ->condition('vid', $vid)
                ->range(0, 1)
                ->execute()
                ->fetchAllAssoc('tid');

            if (count($term_tid)) {
                $tid = key($term_tid);
                if (array_shift($term_tid)->name == $item1) {
                    $node->field_c['und'][]['tid'] = $tid;
                    $tid_parent = $tid;
                } else {
                    $term = taxonomy_term_load(key($term_tid));
                    $term->name = $item1;
                    taxonomy_term_save($term);
                    $node->field_c['und'][]['tid'] = $term->tid;
                    $tid_parent = $term->tid;
                    unset($term);
                }

            } else {

                $term = new stdClass();
                $term->name = $item1;
                $term->description = $desc1;
                $term->vid = $vid;
                taxonomy_term_save($term);
                $node->field_c['und'][0]['tid'] = $term->tid;
                $tid_parent = $term->tid;
                unset($term);

            }

            if ($tid_parent > 0) {

                foreach ($productname['КаталогВторой'] as $desc2 => $item2) {

                    if (!is_string($item2)) {
                        continue;
                    }

                    $term_tid = db_select('taxonomy_term_data', 'n')
                        ->fields('n', array('tid', 'vid', 'name', 'description'))
                        ->condition('description', $desc2)
                        ->condition('vid', $vid)
                        ->range(0, 1)
                        ->execute()
                        ->fetchAllAssoc('tid');

                    if (count($term_tid)) {

                        $term_tid_parent = db_select('taxonomy_term_hierarchy', 'n')
                            ->fields('n', array('tid', 'parent'))
                            ->condition('parent', $tid_parent)
                            ->condition('tid', key($term_tid))
                            ->range(0, 1)
                            ->execute()
                            ->fetchAllAssoc('tid');
                        $tid = key($term_tid);
                        if ((array_shift($term_tid)->name == $item2) AND (count($term_tid_parent))) {
                            $node->field_c['und'][]['tid'] = $tid;
                        } else {
                            $term = taxonomy_term_load($tid);
                            $term->name = $item2;
                            $term->parent = $tid_parent;
                            taxonomy_term_save($term);
                            $node->field_c['und'][]['tid'] = $term->tid;
                        }

                    } else {

                        $term = new stdClass();
                        $term->name = $item2;
                        $term->description = $desc2;
                        $term->vid = $vid;
                        $term->parent = $tid_parent;
                        taxonomy_term_save($term);
                        $node->field_c['und'][]['tid'] = $term->tid;

                    }
                }
            }
        }
    }

    return $node;
}