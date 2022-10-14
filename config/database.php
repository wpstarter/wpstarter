<?php

use WpStarter\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => ws_env('DB_CONNECTION', 'wpdb'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by WpStarter is shown below to make development simple.
    |
    |
    | All database work in WpStarter is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => ws_env('DATABASE_URL'),
            'database' => ws_env('DB_DATABASE', ws_database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => ws_env('DB_FOREIGN_KEYS', true),
        ],
        'wpdb' => [
            'driver' => 'wp',
            'host' => defined('DB_HOST')?DB_HOST:'',
            'port' => 3306,
            'database' => defined('DB_NAME')?DB_NAME:'',
            'username' => defined('DB_USER')?DB_USER:'',
            'password' => defined('DB_PASSWORD')?DB_PASSWORD:'',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => 'wp_',
            'prefix_indexes' => true,
        ],
        'mysql' => [
            'driver' => 'mysql',
            'url' => ws_env('DATABASE_URL'),
            'host' => ws_env('DB_HOST', '127.0.0.1'),
            'port' => ws_env('DB_PORT', '3306'),
            'database' => ws_env('DB_DATABASE', 'forge'),
            'username' => ws_env('DB_USERNAME', 'forge'),
            'password' => ws_env('DB_PASSWORD', ''),
            'unix_socket' => ws_env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => ws_env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => ws_env('DATABASE_URL'),
            'host' => ws_env('DB_HOST', '127.0.0.1'),
            'port' => ws_env('DB_PORT', '5432'),
            'database' => ws_env('DB_DATABASE', 'forge'),
            'username' => ws_env('DB_USERNAME', 'forge'),
            'password' => ws_env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => ws_env('DATABASE_URL'),
            'host' => ws_env('DB_HOST', 'localhost'),
            'port' => ws_env('DB_PORT', '1433'),
            'database' => ws_env('DB_DATABASE', 'forge'),
            'username' => ws_env('DB_USERNAME', 'forge'),
            'password' => ws_env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. WpStarter makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => ws_env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => ws_env('REDIS_CLUSTER', 'redis'),
            'prefix' => ws_env('REDIS_PREFIX', Str::slug(ws_env('APP_NAME', 'wpstarter'), '_').'_database_'),
        ],

        'default' => [
            'url' => ws_env('REDIS_URL'),
            'host' => ws_env('REDIS_HOST', '127.0.0.1'),
            'password' => ws_env('REDIS_PASSWORD', null),
            'port' => ws_env('REDIS_PORT', '6379'),
            'database' => ws_env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => ws_env('REDIS_URL'),
            'host' => ws_env('REDIS_HOST', '127.0.0.1'),
            'password' => ws_env('REDIS_PASSWORD', null),
            'port' => ws_env('REDIS_PORT', '6379'),
            'database' => ws_env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
