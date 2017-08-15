<?php
/**
 * @return array
 * формируем дерево каталога
 */
function klev_derevo_catalog($vid = 35)
{
    $derevo = [];

    $taxonomy_catalog = db_select('taxonomy_term_data', 'f')
        ->fields('f', array('tid', 'name'))
        ->condition('f.vid', $vid)
        ->execute()
        ->fetchAllAssoc('tid');

    if (count($taxonomy_catalog)) {

        foreach ($taxonomy_catalog as $key => $value) {
            $taxonomy_catalog_tid[$key] = $key;
        }

        $taxonomy_hierarchy = db_select('taxonomy_term_hierarchy', 'f')
            ->fields('f', array('tid', 'parent'))
            ->condition('f.tid', $taxonomy_catalog_tid)
            ->execute()
            ->fetchAllAssoc('tid');

        if (count($taxonomy_hierarchy)) {

            foreach ($taxonomy_hierarchy as $key => $value) {

                if ($value->parent == 0) {
                    $derevo[$key]['name'] = $taxonomy_catalog[$key]->name;
                } else {
                    $derevo[$value->parent]['child'][$key]['name'] = $taxonomy_catalog[$key]->name;
                }

            }

        }

    }

    return $derevo;
}