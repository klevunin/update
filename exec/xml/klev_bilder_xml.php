<?php
/**
 * @param $mypn
 * @param $yandex_array
 * подключаем строителей
 */
function klev_bilder_xml($mypn,$yandex_array)
{
    $bilder = ['yandex_market','stock'];

    print '<pre>';
    print '!!!';
    print_r($mypn);
    print '</pre>';

    foreach ($bilder as $item) {
        include __DIR__.'/../bilder/'.$item.'.php';
    }

}