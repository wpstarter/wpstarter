<?php
if(!defined('WS_DIR')){
    define('WS_DIR',dirname(__DIR__));
}
//Load WordPress first
if(!defined('ABSPATH')){
    //Wp loader
    $wploader000001 = function () {
        $wps_parent=dirname(WS_DIR);
        $locations=[
            $wps_parent,dirname(dirname($wps_parent)),
        ];
        foreach ($locations as $location){
            if (file_exists($location . '/wp-load.php')) {
                $haveConfig=false;
                if ( file_exists( $location . '/wp-config.php' ) ) {
                    $haveConfig=true;
                } elseif ( @file_exists( dirname( $location ) . '/wp-config.php' ) && ! @file_exists( dirname( $location ) . '/wp-settings.php' ) ) {
                    $haveConfig=true;
                }
                if($haveConfig) {
                    include $location . '/wp-load.php';
                }
                break;
            }
        }
    };
    $wploader000001();
    unset($wploader000001);
}
//Then load vendor
if(!defined('__WS_VENDOR_AUTOLOAD_LOADED__')) {
    define('__WS_VENDOR_AUTOLOAD_LOADED__',true);
    require WS_DIR . '/vendor/autoload.php';
    if (file_exists(WS_DIR . '/bootstrap/load-custom.php')) {
        require WS_DIR . '/bootstrap/load-custom.php';
    }
    require WS_DIR.'/WordpressStarter.php';
}