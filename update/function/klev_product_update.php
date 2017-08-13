<?php
/**
 * @param $product
 * @param $productname
 * @param $nodearray
 * @return mixed
 * функция добавления товара в базу
 * возврщает массив product id для ноды
 */
function klev_product_update($product, $productname, $nodearray)
{
    $id_product_add_node = [];

    if (isset($nodearray->field_images['und'][0])) {
        $imagesnode = $nodearray->field_images['und'][0];
    }

    foreach ($product['nomen'] as $key => $value) {
        $new = 0;

        $new_product = commerce_product_load_by_sku($product['nomen'][$key]['id']);

        if (!isset($new_product->product_id)) {

            if ($product['nomen'][$key]['СкладМосква'] < 1) {
                continue;
            }
            if ((isset($productname['НеПродаватьНаСайте'])) AND ($productname['НеПродаватьНаСайте'] == 'Да')) {
                continue;
            }

            $new_product = commerce_product_new("product");
            $new_product->status = "1";
            $new_product->uid = "1";
            $new_product->sku = $product['nomen'][$key]['id'];
            $new_product->language = 'und';
            $new_product->created = time();
            $new = 1;
        }

        $new_product->title = trim($productname['title']);

        if (isset($imagesnode)) {
            $new_product = klev_product_images_node($new_product, $imagesnode);
        }

        if (isset($product['nomen'][$key]['Размер'])) {
            $productsize = $product['nomen'][$key]['Размер'];
            if (($product['nomen'][$key]['Размер'] != '-') && ($product['nomen'][$key]['Размер'] != 'E')) {
                $productname['Размер']=$productsize;
            }
        }

        $new_product = klev_taxonomy($new_product, $productname,'Размер',9,'size','field_size',1);

        $new_product = klev_product_price($new_product, $product['nomen'][$key]['Цена']);
        $new_product = klev_product_json($new_product, $product['nomen'][$key], $productname);
        $new_product = klev_product_quantity_store($new_product, $product['nomen'][$key]);
        commerce_product_save($new_product);

        if (!isset($new_product->product_id)) {
            $product_id = commerce_product_load_by_sku($product['nomen'][$key]['id']);
            if (isset($product_id->product_id)) {
                if ($new_product->status == 1) {
                    if ($new_product->commerce_stock['und']['0']['value'] > 0) {
                        $id_product_add_node[$product_id->product_id]['stock'] = $product_id->commerce_stock['und']['0']['value'];
                        $id_product_add_node[$product_id->product_id]['price'] = round($product['nomen'][$key]['Цена']['ЦенаПродажи']);
                        $id_product_add_node[$product_id->product_id]['new'] = $new;
                        $id_product_add_node[$product_id->product_id]['created'] = $product_id->created;
                    }
                }
            }
        } else {

            if ($new_product->status == 1) {
                if ($new_product->commerce_stock['und']['0']['value'] > 0) {
                    $id_product_add_node[$new_product->product_id]['stock'] = $new_product->commerce_stock['und']['0']['value'];
                    $id_product_add_node[$new_product->product_id]['price'] = round($product['nomen'][$key]['Цена']['ЦенаПродажи']);
                    $id_product_add_node[$new_product->product_id]['new'] = $new;
                    $id_product_add_node[$new_product->product_id]['created'] = $new_product->created;
                }
            }
        }

        unset($product_id);
        unset($new_product);

    }

    return $id_product_add_node;
}
