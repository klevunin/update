<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';

$club_cart = db_select('club_cart', 'o')
    ->fields('o', array('number', 'user', 'amount', 'fixed'))
    ->execute()
    ->fetchAllAssoc('number');

/**
 * $files_array[$key][0] = number
 * $files_array[$key][1] = pincod
 * $files_array[$key][2] = amount
 * $files_array[$key][3] = fixed
 * проверка новых карт, если есть добоялвем / обновляем
 */
if (($files = file($discont_cart_new)) && (count($club_cart))) {
    $files_array = [];
    foreach ($files as $key => $value) {
        $files_array[$key] = explode(";", trim($value));
    }


    foreach ($files_array as $key => $value) {

        //проверка пин кода карты
        if ((isset($files_array[$key][1])) && (is_numeric($files_array[$key][1]))) {

            $pincod = $files_array[$key][1];
            $amount = (is_numeric($files_array[$key][2])) ? round(str_replace(",", ".", $files_array[$key][2])) : 0;
            $fixed_file = isset($fixed[$fixed_file = trim($files_array[$key][3])]) ? $fixed_file : null;

            if (isset($club_cart[$number = trim($files_array[$key][0])])) {

                db_update('club_cart')
                    ->fields(array('cod' => $pincod, 'amount' => $amount, 'fixed' => $fixed_file, 'time' => time()))
                    ->condition('number', $number)
                    ->execute();

            } else {

                $new = db_insert('club_cart')
                    ->fields(array(
                        'number' => $number,
                        'cod' => $pincod,
                        'amount	' => $amount,
                        'fixed	' => $fixed_file,
                        'time	' => time(),
                    ))
                    ->execute();

            }
        }
    }


}

/**
 * $files_array[$key][0] = number
 * $files_array[$key][1] = amount
 * $files_array[$key][2] = fixed
 * обновить накопления по картам
 * в идеале только по картам где было изменение накоплении
 */
if (($files = file($discont_cart)) && (count($club_cart))) {
    $files_array = [];
    foreach ($files as $key => $value) {
        $files_array[$key] = explode(";", trim($value));
    }

    foreach ($files_array as $key => $value) {

        if (isset($club_cart[$number = $files_array[$key][0]])) {

            $amount = round(str_replace(",", ".", $files_array[$key][1]));
            $update = ($club_cart[$number]->amount != $files_array[$key][1]) ? 1 : 0;

            if ($update) {
                db_update('club_cart')
                    ->fields(array('amount' => $amount, 'time' => time()))
                    ->condition('number', $number)
                    ->execute();
            }
        }
    }
}


