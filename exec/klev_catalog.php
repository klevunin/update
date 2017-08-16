<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';

require_once __DIR__ . '/function/klev_derevo_catalog.php';
require_once __DIR__ . '/function/klev_getderevo_catalog.php';
require_once __DIR__ . '/function/klev_sex_catalog.php';
require_once __DIR__ . '/function/klev_set_catalog.php';
require_once __DIR__ . '/function/klev_sport_catalog.php';
require_once __DIR__ . '/function/klev_link_txt_sitemap.php';

if (count($derevo = klev_derevo_catalog())) {

    /*получить активные ноды*/
    $node_active = db_select('node', 'f')
        ->fields('f', array('nid'))
        ->condition('f.type', 'product_display')
        ->condition('f.status', 1)
        ->condition('f.promote', 1)
        ->condition('f.sticky', 1)
        ->execute()
        ->fetchAllAssoc('nid');

    foreach ($node_active as $key => $value) {
        $node_id[$key] = $key;
    }

    $tid = [];
    foreach ($derevo as $keyparent => $valueparent) {
        $tid[$keyparent] = $keyparent;
        if ((isset($valueparent['child'])) && (count($valueparent['child']))) {
            foreach ($valueparent['child'] as $keychild => $valuechild) {
                $tid[$keychild] = $keychild;
            }
        }
    }

    /*собираю активные термины*/
    $taxonomy_index = db_select('taxonomy_index', 'f')
        ->fields('f', array('nid', 'tid'))
        ->condition('f.nid', $node_id)
        ->condition('f.tid', $tid)
        ->execute()
        ->fetchAllAssoc('tid');

    if (count($taxonomy_index)) {
        $catalog = klev_getderevo_catalog($derevo, $taxonomy_index,$domainsite);
        $catalog_sex = klev_sex_catalog($derevo, $taxonomy_index, $node_id);

        $catalog_html_head_left = '<ul class="clear">';
        if (count($catalog_sex)) {
            ksort($catalog_sex);
            foreach ($catalog_sex as $item) {
                $catalog_html_head_left .= $item;
            }
        }

        if (count($catalog)) {
            ksort($catalog);
            foreach ($catalog as $item) {
                $catalog_html_head_left .= $item;
            }
        }
        $catalog_html_head_left .= '</ul>';
        klev_set_catalog($catalog_html_head_left,1);
    }


    if (count($sport = klev_sport_catalog($node_id,$domainsite))) {

        $sport_str = '<ul class="clear">';
        foreach ($sport as $item) {
            $sport_str .= $item;
        }
        $sport_str .= '</ul>';

        klev_set_catalog($sport_str,2);
    }
}


print 'ok!';
