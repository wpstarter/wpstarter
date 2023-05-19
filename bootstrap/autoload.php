<?php
if(!defined('WS_DIR')){
    define('WS_DIR',dirname(__DIR__));
}
//Load WordPress first
if(!defined('ABSPATH')){//Standalone autoload
    require WS_DIR.'/bootstrap/load-wp.php';
}
//Then load vendor
if(!defined('__WS_VENDOR_AUTOLOAD_LOADED__')) {
    define('__WS_VENDOR_AUTOLOAD_LOADED__',true);
    require WS_DIR . '/vendor/autoload.php';
    require WS_DIR . '/bootstrap/fill/autoload.php';
    if (file_exists(WS_DIR . '/bootstrap/load-custom.php')) {
        require WS_DIR . '/bootstrap/load-custom.php';
    }
    require WS_DIR.'/WordpressStarter.php';
}