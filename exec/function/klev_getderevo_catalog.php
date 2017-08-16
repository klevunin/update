<?php
/**
 * @param $derevo
 * @param $taxonomy_index
 * @return array
 * подготавливаю массив данных с каталогом
 */
function klev_getderevo_catalog($derevo, $taxonomy_index,$domainsite)
{
    $catalog = [];
    $link = [];

    foreach ($derevo as $key => $value) {

        if (isset($taxonomy_index[$key])) {
            $url_head = '/c/' . $key . '/' . call_user_func('skimir_transliteration', $value['name']);
            $catalog[$value['name']] = '<li><a href="' . $url_head . '" class="mlink">' . $value['name'] . '</a>';
            $link[$url_head] = $url_head;

            if ((isset($value['child'])) && (count($value['child']))) {
                $catalog[$value['name']] .= '<ul class="clear">';
                foreach ($value['child'] as $keychild => $valuechild) {
                    $url = '/c/' . $keychild . '/' . call_user_func('skimir_transliteration', $valuechild['name']);
                    $catalog[$value['name']] .= '<li><a href="' . $url . '" class="mlink">' . $valuechild['name'] . '</a></li>';
                    $link[$url] = $url;
                }
                $catalog[$value['name']] .= '<li><a href="' . $url_head . '" class="mlink">Показать все</a></li></ul>';
                $catalog[$value['name']] .= '</li>';
            }
        }

    }

    if (count($link)) {
        $file_patch = __DIR__ . '/../../file/catalog.txt';
        klev_link_txt_sitemap($link, $file_patch, 0.9,$domainsite);
    }

    return $catalog;
}