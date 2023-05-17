<?php
//Load WordPress first
if(!defined('ABSPATH')){//Standalone autoload
    require __DIR__.'/load-wp.php';
}
//Then load vendor
if(!defined('__WS_VENDOR_AUTOLOAD_LOADED__')) {
    define('__WS_VENDOR_AUTOLOAD_LOADED__',true);
    require __DIR__ . '/../vendor/autoload.php';
    require __DIR__ . '/fill/autoload.php';
    if (file_exists(__DIR__ . '/load-custom.php')) {
        require __DIR__ . '/load-custom.php';
    }
}