<?php
/**
 * XML Sitemaps Generator
 */
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';


$mycenter = '<?xml version=\'1.0\' encoding=\'UTF-8\'?>';
$mycenter .= '<urlset xmlns=\'http://www.sitemaps.org/schemas/sitemap/0.9\'>';
$mycenter .= '<url>';
$mycenter .= '<loc>'.$domainsite.'</loc>';
$mycenter .= '<lastmod>' . date("Y-m-d") . '</lastmod>';
$mycenter .= '<changefreq>daily</changefreq>';
$mycenter .= '<priority>1</priority>';
$mycenter .= '</url>';


if (count($catalog = file(__DIR__ . '/../file/catalog.txt'))) {
    $mycenter .= $catalog[0];
}
if (count($catalog = file(__DIR__ . '/../file/brend.txt'))) {
    $mycenter .= $catalog[0];
}

if ((isset($mypn)) && (count($mypn))) {
    foreach ($mypn as $key => $value) {
        $mycenter .= '<url>';
        $mycenter .= '<loc>'.$domainsite.'/' . htmlspecialchars($mypn[$key]['url']) . '</loc>';
        $mycenter .= '<lastmod>' . date("Y-m-d", $mypn[$key]['changed']) . '</lastmod>';
        $mycenter .= '<changefreq>daily</changefreq>';
        $mycenter .= '<priority>0.8</priority>';
        $mycenter .= '</url>';
    }
}

/*описываю страницы faq*/
$mytype['news_skimir'] = 'news_skimir';
$mytype['skimir'] = 'skimir';

$node_array_nid = db_select('node', 'n')
    ->fields('n', array('nid', 'created', 'changed'))
    ->condition('n.type', $mytype)
    ->condition('n.status', 1)
    ->execute()
    ->fetchAllAssoc('nid');

if (count($node_array_nid)) {
    foreach ($node_array_nid as $item => $value) {
        $link_id['node/' . $item] = 'node/' . $item;
        $linkurl['node/' . $item]['changed'] = $value->changed;
        $linkurl['node/' . $item]['created'] = $value->created;
    }

    $node_url = db_select('url_alias', 'n')
        ->fields('n', array('source', 'alias'))
        ->condition('n.source', $link_id)
        ->execute()
        ->fetchAllAssoc('source');

    foreach ($node_url as $item => $value) {

        $mycenter .= '<url>';
        $mycenter .= '<loc>'.$domainsite.'/' . htmlspecialchars($value->alias) . '</loc>';
        $mycenter .= '<lastmod>' . date("Y-m-d", $linkurl[$item]['changed']) . '</lastmod>';
        $mycenter .= '<changefreq>weekly</changefreq>';
        $mycenter .= '<priority>0.5</priority>';
        $mycenter .= '</url>';
    }
}

$mycenter .= "</urlset>";


if ($fh = fopen($sitemap_file, "w+")) {
    fwrite($fh, $mycenter);
    fclose($fh);
} else {
    echo 'Нет досутпа к файлу '.$sitemap_file.'!';
}
