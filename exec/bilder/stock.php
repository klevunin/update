<?php
/**
 * XML STOCK
 */
if (count($mypn)) {


    $head  = "<?xml version='1.0' encoding='UTF-8'?>";
    $head .= "<!DOCTYPE yml_catalog SYSTEM 'shops.dtd'>";
    $head .= "<yml_catalog date='".date("Y-m-d H:i")."'>";
    $head .= "<shop>";
    $head .= "<name>Сеть спортивных магазинов SKIMiR</name>";
    $head .= "<company>Сеть спортивных магазинов SKIMiR</company>";
    $head .= "<url>https://www.skimir.ru/</url>";
    $head .= "<agency>skimir.ru</agency>";
    $head .= "<email>klevunin@gmail.com</email>";
    $head .= "<currencies>";
    $head .= "<currency id='RUR' rate='1'/>";
    $head .= "</currencies>";
    $head .= "<delivery-options>";
    $head .= "<option cost='300' days='2'/>";
    $head .= "</delivery-options>";


    foreach ($mypn as $key => $value ) {
        foreach ($mypn[$key]['product'] as $key2 => $value2 ) {



        }
    }



}
