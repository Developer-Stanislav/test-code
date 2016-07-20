<?php
if (is_file('config.php')) {
    require_once('config.php');
}

if (!defined('DIR_IMAGE') || !defined('DIR_SYSTEM') || !defined('DIR_TEMPLATE') || !is_dir(DIR_IMAGE) || !is_dir(DIR_SYSTEM) || !is_dir(DIR_TEMPLATE) ) {
    echo "Error config!";
    exit;
}

$path = isset($_GET['path']) ? str_replace('-', '/', $_GET['path']) : '';
$sort = isset($_GET['sort'])  ? $_GET['sort'] : '';
$order = isset($_GET['order'])  ? $_GET['order'] : '';

require_once(DIR_SYSTEM . 'library/file_manager.php');
require_once(DIR_SYSTEM . 'library/render.php');


echo render('header');
$file_manager  = FileManager::getInstance();
echo $file_manager->scan($path)->sort($sort,$order);
echo render('footer');
