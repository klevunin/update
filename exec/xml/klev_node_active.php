<?php
/**
 * @param $product
 * @return array
 * достаем данные по карточки товара
 */
function klev_node_active($product)
{
    $node_array = [];

    if (count($node_big = db_select('node', 'n')
        ->fields('n', array('nid', 'created', 'changed'))
        ->condition('n.nid', $product['node_id'])
        ->condition('n.status', 1)
        ->condition('n.sticky', 1)
        ->condition('n.promote', 1)
        ->execute()
        ->fetchAllAssoc('nid')
    )) {

        foreach ($node_big as $key => $value) {
            if (!isset($product['node_id'][$key])) {
                unset($product['node_id'][$key]);
                continue;
            }

            $node_array[$key]['created'] = $value->created;
            $node_array[$key]['changed'] = $value->changed;
        }

        if (count($node_jsone = db_select('field_data_field_jsone_node', 'n')
            ->fields('n', array('entity_id', 'field_jsone_node_value'))
            ->condition('n.entity_id', $product['node_id'])
            ->execute()
            ->fetchAllAssoc('entity_id')
        )) {
            foreach ($node_jsone as $key => $value) {
                $node_array[$key]['array'] = json_decode($value->field_jsone_node_value['und'][0]['value'], assoc);
            }
        }

        if (count($node_url = db_select('url_alias', 'n')
            ->fields('n', array('source', 'alias'))
            ->condition('n.source', $product['node_url'])
            ->execute()
            ->fetchAllAssoc('source')
        )) {
            foreach ($node_url as $key => $value) {
                $node_id = str_replace("node/", "", $key);
                if (isset($node_array[$node_id])) {
                    $node_array[$node_id]['url'] = $value->alias;
                }

            }
        }

        if (count($field_images = db_select('field_data_field_images', 'n')
            ->fields('n', array('entity_id', 'delta', 'field_images_fid'))
            ->condition('n.entity_id', $product['node_id'])
            ->condition('n.entity_type', 'node')
            ->execute()
            ->fetchAllAssoc('field_images_fid')
        )) {

            foreach ($field_images as $key => $value) {
                $node_field_images_fid[$value->field_images_fid]['delta'] = $value->delta;
                $node_field_images_fid[$value->field_images_fid]['entity_id'] = $value->entity_id;
                $fid_img[$key] = $key;
            }

            if (count($url_img = db_select('file_managed', 'n')
                ->fields('n', array('fid', 'uri'))
                ->condition('n.fid', $fid_img)
                ->execute()
                ->fetchAllAssoc('fid')
            )) {

                foreach ($url_img as $key => $value) {
                    if (isset($product['node_id'][$node_field_images_fid[$key]['entity_id']])) {
                        $node_array[$node_field_images_fid[$key]['entity_id']]['images'][$node_field_images_fid[$key]['delta']] = $value->alias;
                    }
                }
            }
        }

        if (count($field_shades = db_select('field_data_field_shades', 'n')
            ->fields('n', array('entity_id', 'delta', 'field_shades_tid'))
            ->condition('n.entity_id', $product['node_id'])
            ->condition('n.entity_type', 'node')
            ->execute()
            ->fetchAllAssoc('entity_id')
        )) {

            foreach ($field_shades as $key => $value) {
                $field_shades_tid[$value->field_shades_tid] = $value->field_shades_tid;
            }

            if (count($field_shades_taxonomy = taxonomy_term_load_multiple($field_shades_tid))) {
                foreach ($field_shades as $key => $value) {
                    if (isset($field_shades_taxonomy[$value->field_shades_tid])) {
                        $node_array[$key]['shades'] = $field_shades_taxonomy[$value->field_shades_tid]->name;
                    }
                }
            }
        }
    }


    return $node_array;
}