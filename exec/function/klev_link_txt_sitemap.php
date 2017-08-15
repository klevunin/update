<?php
/**
 * @param $link
 * @param $name
 * @param $priority
 * пишем данные для sitemap
 */
function klev_link_txt_sitemap($link,$name,$priority)
{
    $link_sitemap = '';
    foreach ($link as $item => $value) {

        $link_sitemap .= '<url>';
        $link_sitemap .= '<loc>https://www.skimir.ru' . htmlentities($value) . '</loc>';
        $link_sitemap .= '<lastmod>' . date("Y-m-d") . '</lastmod>';
        $link_sitemap .= '<changefreq>daily</changefreq>';
        $link_sitemap .= '<priority>'.$priority.'</priority>';
        $link_sitemap .= '</url>';
    }

    if ($fh = fopen($name, "w+")) {
        fwrite($fh, $link_sitemap);
        fclose($fh);
    } else {
        echo 'Нет досутпа к файлу '.$name.'!';
    }

}