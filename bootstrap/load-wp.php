<?php
if(!defined('ABSPATH')) {
    $wploader000001 = function () {
        $dir = dirname(__DIR__);
        while ($parentDir = dirname($dir)) {
            if ($parentDir === $dir) {
                break;
            }
            if (file_exists($parentDir . '/wp-load.php')) {
                include $parentDir . '/wp-load.php';
                break;
            }
            $dir = $parentDir;
        }
    };
    $wploader000001();
    unset($wploader000001);
}
