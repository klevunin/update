<?php
/**
 * @param $row
 * @param $productname
 * @param $product_id
 * @param $node_id
 * @param $nodearray
 * @return null
 * сообщаем mailchip данные по товарам
 * Require refactoring CODE
 */
function klev_send_mailchip_product($row, $productname, $product_id, $node_id, $nodearray)
{

    if (isset($node_id->nid)) {

        if ((isset($node_id->title_field['und'][0]['value'])) && ($node_id->title_field['und'][0]['value'] != '')) {
            $title = $node_id->title_field['und'][0]['value'];
        } elseif ((isset($node_id->title)) && ($node_id->title != '')) {
            $title = $node_id->title;
        } elseif ((isset($productname['title'])) && ($productname['title'] != '')) {
            $title = trim($productname['title']);
        }

        $alias = drupal_get_path_alias('node/' . $node_id->nid);

        if ($alias != '') {
            //создаем массив данных
            $data['id'] = (string)$node_id->nid;
            $data['title'] = (string)$title;
            $data['url'] = (string)'https://www.skimir.ru/' . $alias;
            $data['vendor'] = (string)$productname['бренд'];

            if ($node_id->field_images['und'][0]['uri']) {
                $images = image_style_path('thumbnail_shop_big', $node_id->field_images['und'][0]['uri']);
                $images = file_create_url($images);
                $images = str_replace(array('http://bn.skimir.ru/', 'http://dev.skimir.ru/','http://dev.klev.me/'), "https://www.skimir.ru/", $images);
                $data['image_url'] = (string)$images;
            } else {
                $images = "";
                $data['image_url'] = "";
            }


            if (count($node_id->field_product['und'])) {

                foreach ($node_id->field_product['und'] as $key => $value) {
                    $data['variants'][] = array(
                        'id' => (string)$value['product_id'],
                        'title' => (string)$node_id->title,
                        'url' => (string)'https://www.skimir.ru/' . $alias,
                        'image_url' => (string)$images,
                        'price' => $product_id[$value['product_id']]['price'],
                        'inventory_quantity' => (integer)$product_id[$value['product_id']]['stock'],
                    );
                }


                /**
                 * Нода уже есть нужно обновить ноду
                 */
                if ((isset($nodearray->nid)) AND ($nodearray->nid > 0)) {

                    $EditProductsPrepare = new \Klev\MailchimpEC\Prepare\EditProductsPrepare();
                    $data_EditProductsPrepare = $EditProductsPrepare->prepareRequest($data);


                    if ($data_EditProductsPrepare) {
                        $EditProductsRequest = new \Klev\MailchimpEC\Request\EditProductsRequest();
                        $result = $EditProductsRequest->request($data_EditProductsPrepare);
                    }

                } else {
                    /**
                     * ноды нет, создаем
                     */
                    $CreateProducts = new \Klev\MailchimpEC\Prepare\CreateProductsPrepare();
                    $data_CreateProducts = $CreateProducts->prepareRequest($data);

                    if ($data_CreateProducts) {
                        $CreateProductsRequest = new \Klev\MailchimpEC\Request\CreateProductsRequest();
                        $result = $CreateProductsRequest->request($data_CreateProducts);

                        if ($result['id'] != $data['id']) {
                            /**
                             * пытаюсь отредактировать
                             */
                            $EditProductsPrepare = new \Klev\MailchimpEC\Prepare\EditProductsPrepare();
                            $data_EditProductsPrepare = $EditProductsPrepare->prepareRequest($data);
                            if ($data_EditProductsPrepare) {
                                $EditProductsRequest = new \Klev\MailchimpEC\Request\EditProductsRequest();
                                $result = $EditProductsRequest->request($data_EditProductsPrepare);
                            }
                        }
                    }
                }

                return null;

            } else {
                return null;
            }


        }
    }

}
