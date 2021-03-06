<?php
/**
 * Bootstrap DRUPAL 7
 **/
ini_set("memory_limit", "512M");
set_time_limit(0);

require_once __DIR__ . '/config.php';

$_SERVER['PWD'] = $site_pwd;
if (!isset($_SERVER['REMOTE_ADDR'])) {
    $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
}
$_SERVER['SERVER_NAME'] = $site_server_name;
$_SERVER['HTTP_HOST'] = $site_server_name;
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
define('DRUPAL_ROOT', $site_pwd);
include_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);