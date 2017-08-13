<?php
ini_set("memory_limit", "512M");
set_time_limit(0);
//Цена
$price['a45d60b0-a356-11e1-b627-001e5848397d'] = "Основная цена продажи";
//Склад
$sclad['c56766fe-68e6-11e4-b2b8-002590e5a8ac'] = "Сампо_опт";
$sclad['d7433c9b-a60c-11e4-b195-00155d011404'] = "SKIMIR_опт";
$sclad['67048d38-8a3e-11e6-bc9e-002590e5a8ac'] = "Одинцово_опт";

$sclad['39f89137-7f52-11e3-96b5-c86000c3119b'] = "ODLO_Сочи_Галактика";
$sclad['851bbfa2-29a6-11e3-95f7-c86000c3119b'] = "ODLO_Сочи_Роза_Хутор";
$sclad['b8bee24d-8f2c-11e4-a191-002590e5a8ac'] = "ODLO_Сочи_Горки_Молл";
$sclad['8e00efdb-2dea-11e4-bb91-002590e5a8ac'] = "ODLO_Снежком";

$sclad['dac3ec11-6a13-11e3-b370-c86000c3119b'] = "SKIMIR_Москва";
$sclad['e94a65fa-8940-11e6-bc9e-002590e5a8ac'] = "SKIMIR_Новосибирск";
$sclad['fb53683a-172b-11e4-b368-002590e5a8ac'] = "SKIMIR_Сахалин";


$sclad['e104e5d7-8654-11e2-bb2f-c86000c3119b'] = "Партнеры";

$sclad['b5b66e68-dc90-11e6-a0ca-002590e5a8ac'] = "СколковоПроТренер";


$sclad_delivery['c56766fe-68e6-11e4-b2b8-002590e5a8ac'] = "Сампо_опт";
$sclad_delivery['d7433c9b-a60c-11e4-b195-00155d011404'] = "SKIMIR_опт";
$sclad_delivery['67048d38-8a3e-11e6-bc9e-002590e5a8ac'] = "Одинцово_опт";
$sclad_delivery['dac3ec11-6a13-11e3-b370-c86000c3119b'] = "SKIMIR_Москва";
$sclad_delivery['8e00efdb-2dea-11e4-bb91-002590e5a8ac'] = "ODLO_Снежком";
$sclad_delivery['e104e5d7-8654-11e2-bb2f-c86000c3119b'] = "Партнеры";
$sclad_delivery['b5b66e68-dc90-11e6-a0ca-002590e5a8ac'] = "СколковоПроТренер";

$sclad_delivery_prioritet['c56766fe-68e6-11e4-b2b8-002590e5a8ac'] = "Сампо_опт";
$sclad_delivery_prioritet['d7433c9b-a60c-11e4-b195-00155d011404'] = "SKIMIR_опт";
$sclad_delivery_prioritet['67048d38-8a3e-11e6-bc9e-002590e5a8ac'] = "Одинцово_опт";
$sclad_delivery_prioritet['dac3ec11-6a13-11e3-b370-c86000c3119b'] = "SKIMIR_Москва";
$sclad_delivery_prioritet['8e00efdb-2dea-11e4-bb91-002590e5a8ac'] = "ODLO_Снежком";


$sclad_delivery_new['c56766fe-68e6-11e4-b2b8-002590e5a8ac'] = "Сампо_опт";
$sclad_delivery_new['d7433c9b-a60c-11e4-b195-00155d011404'] = "SKIMIR_опт";
$sclad_delivery_new['67048d38-8a3e-11e6-bc9e-002590e5a8ac'] = "Одинцово_опт";
$sclad_delivery_new['dac3ec11-6a13-11e3-b370-c86000c3119b'] = "SKIMIR_Москва";
$sclad_delivery_new['8e00efdb-2dea-11e4-bb91-002590e5a8ac'] = "ODLO_Снежком";
$sclad_delivery_new['e104e5d7-8654-11e2-bb2f-c86000c3119b'] = "Партнеры";


$reader = new XMLReader();
$reader->open(__DIR__ . "/../file/offers.xml");
while ($reader->read()) {

    switch ($reader->nodeType) {
        case (XMLREADER::ELEMENT):

            if ($reader->name == "ПакетПредложений" && $reader->nodeType == XMLReader::ELEMENT) {
                $my_status['СодержитТолькоИзменения'] = $reader->getAttribute('СодержитТолькоИзменения');
            }

            if ($reader->name == "Предложение" && $reader->nodeType == XMLReader::ELEMENT) {

                $no_goods = 1;

                $doc = new DOMDocument('1.0', 'UTF-8');
                $xml = simplexml_import_dom($doc->importNode($reader->expand(), true));

                $id = explode("#", $xml->Ид);

                if (!isset($id[1])) {
                   // if (isset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]])) {
                    //     unset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]);
                    //}
                    continue;
                }

                if (isset($xml->ХарактеристикиТовара)) {

                    if (isset($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Наименование)) {
                        if ($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Наименование == 'Цвет') {
                            $color = explode("/", $xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение);
                            $ids = trim($color[0]);
                        }
                    }
                    if (isset($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Наименование)) {
                        if ($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Наименование == 'Цвет') {
                            $color = explode("/", $xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение);
                            $ids = trim($color[0]);
                        }
                    }
                } else {
                    //у товара нет характеристики не выгружаю
                    $no_goods = 0;
                    if (isset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]])) {
                        unset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]);
                    }
                    continue;
                }

                if (isset($xml->Цены->Цена)) {
                    foreach ($xml->Цены->Цена as $key => $value) {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Цена'][$price[trim($value->ИдТипаЦены)]] = trim($value->ЦенаЗаЕдиницу);
                    }
                } else {
                    //если нет цены
                    if (isset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]])) {
                        unset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]);
                    }
                    continue;
                }


                $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['id'] = trim($xml->Ид);
                if (isset($xml->Штрихкод)) {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Штрихкод'] = trim($xml->Штрихкод);
                }

                if (isset($xml->Сезонность)) {
                    $nomen[$id[0]]['Сезонность'] = trim($xml->Сезонность);
                }

                if (isset($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Наименование)) {
                    if ($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Наименование == 'Цвет') {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Цвет'] = trim($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение);
                    } else {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Размер'] = trim($xml->ХарактеристикиТовара->ХарактеристикаТовара[0]->Значение);
                    }
                }
                if (isset($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Наименование)) {
                    if ($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Наименование == 'Цвет') {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Цвет'] = trim($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Значение);
                    } else {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Размер'] = trim($xml->ХарактеристикиТовара->ХарактеристикаТовара[1]->Значение);
                    }
                }



                //Скидка
                if (isset($xml->Цены->ЦенаСоСкидкой)) {
                    if ($xml->Цены->ЦенаСоСкидкой != 0) {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Цена']['ЦенаСоСкидкой'] = trim($xml->Цены->ЦенаСоСкидкой);
                    }
                }

                //МинимальнаяСтоимость
                if (isset($xml->Цены->МинимальнаяСтоимость)) {
                    if ($xml->Цены->МинимальнаяСтоимость != 0) {
                        $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Цена']['МинимальнаяСтоимость'] = trim($xml->Цены->МинимальнаяСтоимость);
                    }
                }

                //Приоритет
                if (isset($xml->Приоритет)) {
                    $nomen[$id[0]]['nomen'][$ids]['Приоритет'] = trim($xml->Приоритет);
                } else {
                    $nomen[$id[0]]['nomen'][$ids]['Приоритет'] = 0;
                }

                $col = 0;
                $col_delivery = 0;
                $col_delivery_new = 0;
                $col_delivery_prioritet = 0;

                if (isset($xml->КоличествоНаСкладах->КоличествоНаСкладе)) {
                    foreach ($xml->КоличествоНаСкладах->КоличествоНаСкладе as $key => $value) {
                        if (isset($sclad[trim($value->ИдСклада)])) {
                            $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Склад'][$sclad[trim($value->ИдСклада)]] = trim($value->Количество);
                            $nomen[$id[0]]['nomen'][$ids]['Склад'][$sclad[trim($value->ИдСклада)]] = $sclad[trim($value->ИдСклада)];
                            $col += $value->Количество;
                        }
                        //смотрим склады с которых етсь доставка
                        if (isset($sclad_delivery[trim($value->ИдСклада)])) {
                            $col_delivery += $value->Количество;
                        }
                        if (isset($sclad_delivery_new[trim($value->ИдСклада)])) {
                            $col_delivery_new += $value->Количество;
                        }
                        if (isset($sclad_delivery_prioritet[trim($value->ИдСклада)])) {
                            $col_delivery_prioritet += $value->Количество;
                        }
                    }
                }

                if ($col > 0) {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Количество'] = $col;
                } else {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Количество'] = 0;
                }
                if ($col_delivery > 0) {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМосква'] = $col_delivery;
                } else {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМосква'] = 0;
                }
                if ($col_delivery_new > 0) {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМоскваNew'] = $col_delivery_new;
                } else {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМоскваNew'] = 0;
                }

                if ($col_delivery_prioritet > 0) {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМоскваПриоритет'] = $col_delivery_prioritet;
                } else {
                    $nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['СкладМоскваПриоритет'] = 0;
                }

                unset($col);
                unset($col_delivery);
                unset($col_delivery_new);
                unset($col_delivery_prioritet);

                //удаляем товары которые идут при полной выгрузки пустыми по складам
                if ((isset($my_status['СодержитТолькоИзменения'])) AND ($my_status['СодержитТолькоИзменения'] == 'false')) {
                    if (!isset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]['Склад'])) {
                        unset($nomen[$id[0]]['nomen'][$ids]['nomen'][$id[1]]);
                    }
                }

            }
    }
}


$reader->close();
unset($price);
unset($sclad);
