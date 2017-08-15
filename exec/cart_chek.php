<?php

set_time_limit(0);
gc_enable();
$_SERVER['PWD']='/home/www/multishop';
if ( !isset( $_SERVER['REMOTE_ADDR'] ) ) {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}

$_SERVER['SERVER_NAME'] = 'devbigbase.skimir.ru';
$_SERVER['HTTP_HOST'] = 'devbigbase.skimir.ru';
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
//$start = microtime(true);
define('DRUPAL_ROOT', '/home/www/multishop');
include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

$files=file("/home/swop/ftp/card/discont.txt");

foreach ($files as $key => $value ) {
    $files_2[$key]=explode( ";" ,trim($value));
}


//******Проверка карт лыжного мира*****///

$skimir_cart = db_select('club_cart', 'o')
    ->fields('o', array('number','user','amount','fixed'))
    ->execute()
    ->fetchAllAssoc('number');


foreach ($files_2 as $key => $value) {

    if (isset($skimir_cart[$files_2[$key][0]])) {

        $files_2[$key][1]=str_replace(",",".",$files_2[$key][1]);
        $skimir_cart[$files_2[$key][0]]->amount=round($skimir_cart[$files_2[$key][0]]->amount,2);
        $files_2[$key][1]=round($files_2[$key][1],2);

        if ($skimir_cart[$files_2[$key][0]]->amount != $files_2[$key][1] ) {


            if (isset($skimir_cart[$skimir_cart[$files_2[$key][0]]->number])) {

                if ($my_cart[$files_2[$key][0]]->amount != $files_2[$key][1]) {
                    $q=db_update('club_cart');
                    $q->fields(array('amount' => $files_2[$key][1]));
                    $q->condition('number', $skimir_cart[$files_2[$key][0]]->number);
                    $q->execute();
                }

            }

        }


    }

}

$recipient = "klevunin@gmail.com";
$subject = trim("Обновил карты");
$body="Обновил карты";
$header="Content-type: text/html; charset=\"utf-8\"\r\n";
$header.="From: База обновлена ODLO <webmail@skimir.ru>\r\n";
$formsent = mail($recipient,$subject,$body, $header);

