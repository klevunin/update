<?php
/**
 * @param $mypn
 * @param $yandex_array
 * подключаем строителей
 */
function klev_bilder_xml($mypn,$yandex_array)
{
    $bilder = ['yandex_market','stock'];

    foreach ($bilder as $item) {
        include __DIR__.'/../bilder/'.$item.'.php';
    }

}