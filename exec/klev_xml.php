<?php
/**
 * XML
 */
error_reporting(E_ALL);
require_once __DIR__ . '/../bootstap.php';

require_once __DIR__ . '/xml/klev_get_product_id.php';
require_once __DIR__ . '/xml/klev_product_json.php';
require_once __DIR__ . '/xml/klev_node.php';
require_once __DIR__ . '/xml/klev_node_active.php';
require_once __DIR__ . '/xml/klev_yandex_yml.php';
require_once __DIR__ . '/xml/klev_bilder_xml.php';

$update = 0;

if (count($product_id = klev_get_product_id())) {

    if (count($product = klev_node($product_id, $product_array = klev_product_json($product_id)))) {

        if (count($node_array = klev_node_active($product))) {

            if (count($node_array)) {

                $active_node_id = [];
                $mypn = [];

                foreach ($node_array as $key => $value) {
                    if (isset($node_array[$key]['url'])) {
                        $mypn[$key]['url']=$node_array[$key]['url'];
                    } else {
                        continue;
                    }
                    $mypn[$key]=$value;
                    if (isset($node_array[$key]['array'])) {
                        $mypn[$key]['array']=$node_array[$key]['array'];
                    }
                    if (isset($node_array[$key]['images'])) {
                        $mypn[$key]['images']=$node_array[$key]['images'];
                    }
                    if (isset($node_array[$key]['shades'])) {
                        $mypn[$key]['shades']=$node_array[$key]['shades'];
                    }

                    $active_node_id[$key] = $key;
                }

                unset($node_array);
                unset($product_array);
                unset($product);
                unset($product_id);

                $yandex_array = klev_yandex_yml($active_node_id);

                /**
                 * запускаем строителей
                 */
                klev_bilder_xml($mypn,$yandex_array);

            }

        }

    }
}


if (!$update) {
    klev_bilder_xml(null,null);
}


