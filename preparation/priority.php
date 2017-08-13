<?php
ini_set("memory_limit", "512M");
set_time_limit(0);
foreach ($nomen as $key => $value) {
    foreach ($nomen[$key]['nomen'] as $key2 => $value2) {

        $sclad_moskow = 0;
        $sclad_moskow_prior = 0;
        $prioritet = 0;
        foreach ($nomen[$key]['nomen'][$key2]['nomen'] as $key3 => $value3) {

            if ($my_status['СодержитТолькоИзменения'] == 'false') {

                if ($nomen[$key]['НеПродаватьНаСайте'] == "Да") {
                    if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Склад'])) {
                        unset($nomen[$key]['nomen'][$key2]['nomen'][$key3]);
                    }
                    $nomen[$key]['nomen'][$key2]['Количество'] = 0;

                    $nomen[$key]['nomen'][$key2]['Приоритет'] = 0;
                    continue;
                }


            } else {

                if ($nomen[$key]['НеПродаватьНаСайте'] == "Да") {
                    if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Склад'])) {
                        unset($nomen[$key]['nomen'][$key2]['nomen'][$key3]);
                    }
                    $nomen[$key]['nomen'][$key2]['Количество'] = 0;

                    $nomen[$key]['nomen'][$key2]['Приоритет'] = 0;
                    continue;
                }
                /*
                 if ($nomen[$key]['НеПродаватьНаСайте'] == "Да") {

                     unset($nomen[$key]);
                     continue;
                 }
         */
            }

            if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМосква'] > 0) {
                $sclad_moskow += 1;

                if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМосква'] > 10) {
                    $sclad_moskow_prior += 1;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМосква'] > 20) {
                    $sclad_moskow_prior += 2;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМосква'] > 50) {
                    $sclad_moskow_prior += 3;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМосква'] > 100) {
                    $sclad_moskow_prior += 4;
                }

                if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМоскваПриоритет'] > 0) {
                    $sclad_moskow += 1;
                    $sclad_moskow_prior += 1;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМоскваПриоритет'] > 20) {
                    $sclad_moskow_prior += 2;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМоскваПриоритет'] > 50) {
                    $sclad_moskow_prior += 3;
                } elseif ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['СкладМоскваПриоритет'] > 100) {
                    $sclad_moskow_prior += 4;
                }

            }

        }
//итог по цвет
        $col_har = sizeof($nomen[$key]['nomen'][$key2]['nomen']);
// смотрим варианты размерной сетки. Чем больше есть в наличии размерная сетка тем больше приоритет
        if ($col_har == 0) {
            $prioritet = 0;
        } else {
            $prioritet = ($sclad_moskow / $col_har) * 10;
        }
// добавляем приоритет по количеству товара на складе
        $prioritet = $prioritet + $sclad_moskow_prior;


        if ($prioritet > 30) {
            $prioritet = 30;
        }

        if (isset($nomen[$key]['Приоритет'])) {
            $prioritet = $prioritet + $nomen[$key]['Приоритет'];
        }


        $nomen[$key]['nomen'][$key2]['Приоритет'] = round($prioritet);


    }


}

