<?php
/***
 * Plugin name: WpStarter
 * Version:     1.0.4
 * Description: WpStarter Plugin
 * Author:      As247
 * Author URI:  https://github.com/as247
 *
 */

if(!defined('__WS_FILE__') && defined('ABSPATH')) {//Safe load
    define('__WS_FILE__', __FILE__);
    define('WS_VERSION', '1.3');
    if (!defined('WS_DIR')) {
        define('WS_DIR', __DIR__);
    }
    require __DIR__.'/WordpressStarter.php';
    if (!wp_installing()) {
        WordpressStarter::make()->run();
    }

}