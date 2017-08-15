<?php
/**
 * Подготовка ссылок на категории брендов
 * Подготовка ссылок для sitemap
 */
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';

$nid = [];
$brand = [];
$field_brand = [];


$my_node = db_select('node', 't')
    ->fields('t', array('nid'))
    ->condition('t.type', 'product_display')
    ->condition('t.status', 1)
    ->condition('t.promote', 1)
    ->condition('t.sticky', 1)
    ->execute()
    ->fetchAllAssoc('nid');

if (count($my_node)) {
    foreach ($my_node as $key => $value) {
        $nid[$key] = $key;
    }
}

if (count($nid)) {
    $field_brand = db_select('field_data_field_brand', 't')
        ->fields('t', array('field_brand_tid'))
        ->condition('t.entity_id', $nid)
        ->execute()
        ->fetchAllAssoc('field_brand_tid');
}

if ((count($field_brand)) && (count($nid))) {
    foreach ($field_brand as $key => $value) {

        $field_brand_count = db_select('field_data_field_brand', 't')
            ->fields('t', array('field_brand_tid'))
            ->condition('t.field_brand_tid', $key)
            ->condition('t.entity_id', $nid)
            ->countQuery()
            ->execute()
            ->fetchField();

        $brand_count[$field_brand_count][$key] = $key;
        $brand[$key] = $key;

    }

    $brand_tax = taxonomy_term_load_multiple($brand);
    krsort($brand_count);
}


$html_brend = '<div class="goods-line brands">
    <div class="container">
        <div class="row">
            <h2>Наши бренды</h2><div class="carousel">
                <ul class="clear" id="brands">';

$i = 1;
foreach ($brand_count as $key => $value) {
    foreach ($brand_count[$key] as $key2 => $value2) {

        if (function_exists('skimir_transliteration')) {
            $transliterated = skimir_transliteration($brand_tax[$key2]->name);
            $url = '/c/' . $key2 . '/' . $transliterated;
        } else {
            $url = '/c/' . $key2 . '/brand';
        }
        $my_zapros[$link] = $link;

        if ($i > 24) {
            continue;
        }

        if (($i == 1) || ($i == 9) || ($i == 17)) {
            $html_brend .= '<li class="tr">';
        }

        $i = $i + 1;


        $link = str_replace($domen_replace, "", image_style_url('brand_mini', $brand_tax[$key2]->field_imgtk['und'][0]['uri']));

        $html_brend .= '<div class="brand">
                            <a href="' . $url . '""><img src="' . $link . '" alt="' . $brand_tax[$key2]->name . '"></a>
                        </div>';
    }
}
$html_brend .= ' </ul>
            </div>
        </div>
    </div>
</div>';

print $html_brend;

$brand_sitemap = '';
foreach ($my_zapros as $key => $value) {

    $brand_sitemap .= '<url>';
    $brand_sitemap .= '<loc>https://www.skimir.ru' . urlencode($key) . '</loc>';
    $brand_sitemap .= '<lastmod>' . date("Y-m-d") . '</lastmod>';
    $brand_sitemap .= '<changefreq>daily</changefreq>';
    $brand_sitemap .= '<priority>0.9</priority>';
    $brand_sitemap .= '</url>';
}


db_update('my_big_menu')
    ->fields(array('my_catalog' => $html_brend, 'time' => time()))
    ->condition('id', 'brend')
    ->execute();


if ($fh = fopen($sitemap_brend, "w+")) {
fwrite($fh, $brand_sitemap);
fclose($fh);
} else {
    echo 'Нет досутпа к файлу!';
}

