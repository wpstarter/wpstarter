<?php
if(!defined('WS_DIR')){
    define('WS_DIR',dirname(__DIR__));
}
if(!defined('ABSPATH')) {
    $wploader000001 = function () {
        $wps_parent=dirname(WS_DIR);
        $locations=[
            $wps_parent,dirname(dirname($wps_parent)),
        ];
        foreach ($locations as $location){
            if (file_exists($location . '/wp-load.php')) {
                include $location . '/wp-load.php';
                break;
            }
        }
    };
    $wploader000001();
    unset($wploader000001);
}
