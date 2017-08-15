<?php
/**
 * @param $catalog
 * обновляем даные с каталогом
 */
function klev_set_catalog($catalog,$id)
{

    $my_catalog = db_select('my_catalog', 'n')
        ->fields('n', array('catalog'))
        ->condition('n.id', $id)
        ->execute()
        ->fetchField();

    if ($my_catalog) {

        db_update('my_catalog')
            ->fields(array('catalog' => $catalog))
            ->condition('id', $id)
            ->execute();
    } else {

        $new = db_insert('my_catalog')
            ->fields(array(
                'id' => $id,
                'catalog' => $catalog,
            ))
            ->execute();
    }
}