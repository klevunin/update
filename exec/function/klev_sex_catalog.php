<?php
/**
 * @param $derevo
 * @param $taxonomy_index
 * @param $node_id
 * @return array
 * строим доп каталог по полу
 */

function klev_sex_catalog($derevo, $taxonomy_index, $node_id)
{
    $catalog_sex = [];

    $sex[2382] = 'Мужская экипировка';
    $sex[2383] = 'Женская экипировка';
    $sex[2384] = 'Детская экипировка';

    $tax[2392] = 'Для бега';
    $tax[2391] = 'Для велоспорта';
    $tax[2390] = 'Для лыжного спорта';
    $tax[2395] = 'Для скандинавской ходьбы';
    $tax[2393] = 'Для фитнеса';
    $tax[2394] = 'Для туризма';
    $tax[6359] = 'Термобелье';
    $tax[6356] = 'Одежда';
    $tax[6361] = 'Обувь';


    foreach ($sex as $key => $value) {

        if (call_user_func('getTaxonomy', $key, $node_id)) {
            if ((count($nid = call_user_func('getTaxonomyArray', $key, $node_id))) && ($value_name = call_user_func('getTaxonomyName',$key))) {
                $url_head = '/c/' . $key . '/' . call_user_func('skimir_transliteration', $value_name);
                $catalog_sex[$value] = '<li><a href="' . $url_head . '" class="mlink">' . $value . '</a>';
                $link[$url_head] = $url_head;
                $catalog_sex_tax = '';
                foreach ($tax as $keytax => $valuetax) {
                    if ((count(call_user_func('getTaxonomyArray', $keytax, $nid))) && ($name_url = call_user_func('getTaxonomyName',$keytax))) {
                        $url = '/c/' . $keytax . '/' . call_user_func('skimir_transliteration', $name_url).'?f[]=field_sex:'.$key;
                        $catalog_sex_tax .= '<li><a href="'. $url . '" class="mlink">' . $valuetax . '</a></li>';
                        $link[$url] = $url;
                    }
                }

                if ($catalog_sex_tax) {

                    $catalog_sex[$value] .= '<ul class="clear">';
                    $catalog_sex[$value] .= $catalog_sex_tax;
                    $catalog_sex[$value] .= '<li><a href="' . $url_head . '" class="mlink">Показать все</a></li>';
                    $catalog_sex[$value] .= '</ul>';

                }

                $catalog_sex[$value] .= '</li>';

            }
        }
    }

    return $catalog_sex;
}


function getTaxonomy($tid, $node_id)
{

    $taxonomy_index = db_select('taxonomy_index', 'f')
        ->fields('f', array('tid'))
        ->condition('f.nid', $node_id)
        ->condition('f.tid', $tid)
        ->range(0, 1)
        ->execute()
        ->fetchField();

    return $taxonomy_index;
}


function getTaxonomyArray($tid, $node_id)
{
    $nid = [];

    $taxonomy_index = db_select('taxonomy_index', 'f')
        ->fields('f', array('nid', 'tid'))
        ->condition('f.nid', $node_id)
        ->condition('f.tid', $tid)
        ->execute()
        ->fetchAllAssoc('nid');

    if (count($taxonomy_index)) {
        foreach ($taxonomy_index as $key => $value) {
            $nid[$key] = $key;
        }
    }

    return $nid;
}


function getTaxonomyName($tid)
{

    $taxonomy_index = db_select('taxonomy_term_data', 'f')
        ->fields('f', array('name'))
        ->condition('f.tid', $tid)
        ->range(0, 1)
        ->execute()
        ->fetchField();

    return $taxonomy_index;
}