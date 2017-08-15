<?php


function klev_sport_catalog($nid)
{
    $sport = [];
    $link = [];


    $taxonomy_sport = db_select('taxonomy_term_data', 'f')
        ->fields('f', array('tid', 'vid', 'name'))
        ->condition('f.vid', 30)
        ->execute()
        ->fetchAllAssoc('tid');

    foreach ($taxonomy_sport as $key => $value) {
        $tid[$key] = $key;
    }

    $taxonomy_sport = db_select('taxonomy_term_data', 'f')
        ->fields('f', array('tid', 'vid', 'name', 'description'))
        ->condition('f.vid', 30)
        ->condition('f.tid', $tid)
        ->execute()
        ->fetchAllAssoc('tid');

    if (count($taxonomy_sport)) {

        foreach ($taxonomy_sport as $key => $value) {
            $sport[$value->name] = '<li><a href="/c/' . $key . '/' . call_user_func('skimir_transliteration', $value->name) . '" class="mlink">' . $value->name . '</a></li>';
            $link['/c/' . $key . '/' . call_user_func('skimir_transliteration', $value->name)] = '/c/' . $key . '/' . call_user_func('skimir_transliteration', $value->name);
        }

    }

    if (count($link)) {
        $file_patch = __DIR__ . '/../../file/sport.txt';
        klev_link_txt_sitemap($link, $file_patch, 0.9);
    }

    return $sport;
}
