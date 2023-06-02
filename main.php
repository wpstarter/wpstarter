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
    /**
     * Your application version, free to change
     */
    define('WS_VERSION', '1.6.x');

    /***
     * Do not change anything after this line
     */
    define('__WS_FILE__', __FILE__);
    if (!defined('WS_DIR')) {
        define('WS_DIR', __DIR__);
    }
    require __DIR__.'/bootstrap/autoload.php';
    if (!wp_installing()) {
        WordpressStarter::make()->run();
    }

}