<?php
/**
 * @param $node
 * @param $productname
 * @return mixed
 * достаем описание у карточки с таким же артикулом для новой карточки
 */
function klev_node_json_old($node, $productname)
{
    if ((isset($productname['article'])) && ($productname['article'] != '')) {

        $articlenode = db_select('field_data_field_articlenode', 'n')
            ->fields('n', array('entity_id'))
            ->condition('n.field_articlenode_value', $productname['article'])
            ->range(0, 1)
            ->execute()
            ->fetchField();

        if ($articlenode > 0) {

            $jsone_node = db_select('field_data_field_jsone_node', 'n')
                ->fields('n', array('field_jsone_node_value'))
                ->condition('n.entity_id', $articlenode)
                ->range(0, 1)
                ->execute()
                ->fetchField();

            if ((isset($jsone_node)) && ($jsone_node != '')) {
                $node->field_jsone_node['und'][0]['value'] = $jsone_node;
            }

        }

    }

    return $node;
}