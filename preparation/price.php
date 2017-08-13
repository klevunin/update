<?php
ini_set("memory_limit", "512M");
set_time_limit(0);

foreach ($nomen as $key => $value) {

    foreach ($nomen[$key]['nomen'] as $key2 => $value2) {
        foreach ($nomen[$key]['nomen'][$key2]['nomen'] as $key3 => $value3) {


            if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'])) {
                if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'])) {

                    if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'] < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                        $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                    }

                    $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'];
                } else {

                    if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                        $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                    }
                    $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'];
                }
            } else {

                if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'])) {
                    $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаСоСкидкой'];
                } else {
                    $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'] = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'];
                }
            }

            /*товар со скидкой*/
            if ($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'] != $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи']) {
                $nomen[$key]['nomen'][$key2]['скидка'] = 'Товары со скидкой';
            }

            $price_3 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.97;
            $price_5 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.95;
            $price_7 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.93;
            $price_10 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.90;
            $price_15 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.85;
            $price_20 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.80;
            $price_25 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.75;
            $price_30 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.70;
            $price_50 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['Основная цена продажи'] * 0.50;

            if ($price_3 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_3 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_5 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_5 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_7 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_7 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_10 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_10 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_15 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_15 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_20 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_20 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_25 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_25 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_30 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_30 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if ($price_50 > $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи']) {
                $price_50 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['ЦенаПродажи'];
            }

            if (isset($nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'])) {

                if ($price_3 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_3 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_5 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_5 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_7 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_7 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_10 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_10 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_15 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_15 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_20 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_20 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_25 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_25 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_30 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_30 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }

                if ($price_50 < $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость']) {
                    $price_50 = $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['МинимальнаяСтоимость'];
                }
            }

            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][3] = round($price_3);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][5] = round($price_5);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][7] = round($price_7);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][10] = round($price_10);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][15] = round($price_15);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][20] = round($price_20);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][25] = round($price_25);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][30] = round($price_30);
            $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Цена']['clubcart'][50] = round($price_50);


        }


    }

}

