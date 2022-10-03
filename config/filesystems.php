<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => ws_env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => ws_storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => ws_storage_path('app/public'),
            'url' => ws_env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => ws_env('AWS_ACCESS_KEY_ID'),
            'secret' => ws_env('AWS_SECRET_ACCESS_KEY'),
            'region' => ws_env('AWS_DEFAULT_REGION'),
            'bucket' => ws_env('AWS_BUCKET'),
            'url' => ws_env('AWS_URL'),
            'endpoint' => ws_env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => ws_env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        ws_public_path('storage') => ws_storage_path('app/public'),
    ],

];
