<?php
/**
 * @param $nid
 * @reindex re-indexing domain node
 */

function klev_reIndexSearch($nid)
{
    $reindex = ['dev.skimir.ru','skimir.ru','odlo.ru','dev.odlo.ru'];

    if (is_numeric(nid)) {
        foreach ($reindex as $file) {
            exec("/usr/bin/php ".__DIR__."/reindex/".$file.".php $nid > /dev/null &");
        }
    }
}