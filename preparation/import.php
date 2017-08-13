<?php
ini_set("memory_limit", "512M");
set_time_limit(0);
require __DIR__ . '/offers.php';

$reader = new XMLReader();
$reader->open(__DIR__ . "/../file/import.xml");
while ($reader->read()) {

    switch ($reader->nodeType) {
        case (XMLREADER::ELEMENT):

            if ($reader->name == "Товар" && $reader->nodeType == XMLReader::ELEMENT) {
                $doc = new DOMDocument('1.0', 'UTF-8');
                $xml = simplexml_import_dom($doc->importNode($reader->expand(), true));


                $id = trim($xml->Ид);
                if (!isset($nomen[$id])) {
                    unset($nomen[$id]);
                    continue;
                }

                $nomen[$id]['id'] = trim($xml->Ид);
                $nomen[$id]['Артикул'] = trim($xml->Артикул);
                $nomen[$id]['Наименование'] = trim($xml->Наименование);


                $nomen[$id]['БазоваяЕдиница'] = trim($xml->БазоваяЕдиница);


                //КаталогПервый
                if (isset($xml->Каталог1)) {
                    $cat1 = trim($xml->Каталог1);

                }
                //КаталогВторой
                if (isset($xml->Каталог2)) {
                    $cat2 = trim($xml->Каталог2);
                }
                //КаталогТретий
                if (isset($xml->Каталог3)) {
                    $cat3 = trim($xml->Каталог3);
                }
                //Пол
                if (isset($xml->Пол)) {
                    $nomen[$id]['Пол'] = trim($xml->Пол);
                }
                //ПродажаИМ
                if (isset($xml->НеПродаватьНаСайте)) {
                    $nomen[$id]['НеПродаватьНаСайте'] = trim($xml->НеПродаватьНаСайте);
                }
                if (isset($xml->НеПродаватьНаCБР)) {
                    $nomen[$id]['НеПродаватьНаCБР'] = trim($xml->НеПродаватьНаCБР);
                }
                //Приоритет
                if (isset($xml->Приоритет)) {
                    $nomen[$id]['Приоритет'] = trim($xml->Приоритет);
                }
                //Модель
                if (isset($xml->Модель)) {
                    $nomen[$id]['Модель'] = trim($xml->Модель);
                }

                //Предоплата
                if ((isset($xml->Предоплата)) AND (trim($xml->Предоплата) == 'Да')) {
                    $nomen[$id]['Предоплата'] = trim($xml->Предоплата);
                }
                //КоэфДоставки
                if ((isset($xml->КоэфДоставки)) AND (trim($xml->КоэфДоставки) != '0')) {
                    $nomen[$id]['КоэфДоставки'] = trim($xml->КоэфДоставки);
                } else {
                    $nomen[$id]['КоэфДоставки'] = 1;
                }
                //Спорт
                if (count($xml->Спорт->СпортРеквизита) > 0) {
                    foreach ($xml->Спорт->СпортРеквизита as $key => $value) {
                        $nomen[$id]['Спорт'][trim($value->СпортНаименование)] = trim($value->СпортНаименование);
                    }
                }

                //Технология
                if (count($xml->Спорт->ТехнологияРеквизита) > 0) {
                    foreach ($xml->Спорт->ТехнологияРеквизита as $key => $value) {
                        $nomen[$id]['Технология'][trim($value->ТехнологияНаименование)] = trim($value->ТехнологияНаименование);
                    }
                }

                //Фильтр
                if (sizeof($xml->Спорт->ФильтрРеквизита) > 0) {
                    foreach ($xml->Спорт->ФильтрРеквизита as $key => $value) {
                        $nomen[$id]['Фильтр'][trim($value->ФильтрНаименование)] = trim($value->ФильтрНаименование);
                    }
                }

                if (count($xml->ЗначенияРеквизитов->ЗначениеРеквизита) > 0) {
                    foreach ($xml->ЗначенияРеквизитов->ЗначениеРеквизита as $key => $value) {
                        if ($value->Наименование == 'ВидНоменклатуры') {
                            $nomen[$id]['ВидНоменклатуры'] = trim($value->Значение);
                        }
                        if ($value->Наименование == 'ТипНоменклатуры') {
                            $nomen[$id]['ТипНоменклатуры'] = trim($value->Значение);
                        }
                        if ($value->Наименование == 'Полное наименование') {
                            $nomen[$id]['Полное наименование'] = trim($value->Значение);
                        }
                    }
                }


            }


            if ($reader->name == "Каталог1" && $reader->nodeType == XMLReader::ELEMENT) {
                $nomen[$id]['КаталогПервый'][trim($reader->getAttribute('kod'))] = $cat1;
                $cat1_my = trim($reader->getAttribute('kod'));
            }
            if ($reader->name == "Каталог2" && $reader->nodeType == XMLReader::ELEMENT) {
                $nomen[$id]['КаталогВторой'][trim($reader->getAttribute('kod'))] = $cat2;
                $mysupercat[trim($reader->getAttribute('kod'))] = $cat1_my;
            }
            if ($reader->name == "Каталог3" && $reader->nodeType == XMLReader::ELEMENT) {
                $nomen[$id]['КаталогТретий'][trim($reader->getAttribute('kod'))] = $cat3;
            }

    }

}
$reader->close();

foreach ($nomen as $key => $value) {
    foreach ($nomen[$key]['nomen'] as $key2 => $value2) {
        foreach ($nomen[$key]['nomen'][$key2]['nomen'] as $key3 => $value3) {
            $nomen[$key]['nomen'][$key2]['Количество'] += $nomen[$key]['nomen'][$key2]['nomen'][$key3]['Количество'];
        }
    }
}

