<?php
/**
 * @param $product
 * @param $productname
 * @param $product_id
 * @param $nodearray
 * @return bool|mixed|stdClass
 * обновляем или добавляем картчоку товара
 */
function klev_node_update($productname, $product_id, $nodearray)
{
    if ($productname['article'] == '') {
        return null;
    }
    $artcolor = trim($productname['article']) . '/' . trim($productname['color']);

    if ((isset($nodearray->field_artcolor['und'][0]['value'])) && ($nodearray->field_artcolor['und'][0]['value'] == $artcolor)) {
        $node = $nodearray;
        $my_new_node = 2;
    } else {

        if ((sizeof($product_id) < 1)) {
            return null;
        }
        if ((isset($productname['НеПродаватьНаСайте'])) && ($productname['НеПродаватьНаСайте'] == 'Да')) {
            return null;
        }
        /*создаем ноду*/
        $node = new stdClass();
        $node->type = "product_display";
        node_object_prepare($node);
        $node->language = 'und';
        $node->uid = 1;
        $node->field_artcolor['und'][0]['value'] = $artcolor;
        $my_new_node = 1;
        /*проверяем есть ли артикул с описанием в базе*/
        $node = klev_node_json_old($node, $productname);
    }

    /*обновляем всегда*/
    /*Название*/
    $node->title = trim($productname['title']);
    /*Артикул*/
    $node->field_articlenode['und'][0]['value'] = $productname['article'];
    /*обновляем продукты*/
    $node = klev_product_node_add($node, $product_id);
    /*обновляем BIG каталог 1С*/
    $node = klev_node_catalog($node, $productname);
    /*обновляем Каткгорию 1С*/
    $node = klev_taxonomy($node, $productname,'КаталогТретий',28,'catthird','field_cat3',0);
    /*обновляем ПОЛ 1С*/
    $node = klev_node_sex($node, $productname);
    /*обновляем бренд 1С*/
    $node = klev_node_brand($node, $productname);
    /*обновляем спорт 1С*/
    $node = klev_node_sport($node, $productname);
    /*обновляем технологии 1С*/
    $node = klev_taxonomy($node, $productname,'Технология',34,'tech','field_tech',0);
    /*обновляем фильтер 1С*/
    $node = klev_taxonomy($node, $productname,'Фильтр',31,'filter_1','field_filter_1',0);
    /*обновляем скидок 1С*/
    $node = klev_node_sale($node, $productname);
    /*обновляем сезон 1С*/
    $node = klev_node_sezon($node, $productname,10);
    /*обновялем model*/
    $node = klev_node_model($node, $productname);
    /*Приоритет*/
    $node = klev_node_priority($node, $productname);
    /*убираем или ставим продажу*/
    $node = klev_do_not_sell_on_the_site($node, $productname);
    /*обновляем масив данных node*/
    $node = klev_node_json($node, $productname);
    //снимем или оставляем ноду в продаже
    $node = klev_node_active($node);
    //сохраняем ноду и очищаем кеш
    klev_node_save($node, $productname, $my_new_node);
    //запускаем переиндексацию для SOLR
    klev_reIndexSearch($node->nid);

    return $node;
}
