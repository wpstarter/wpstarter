<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => ws_env('APP_NAME', 'WpStarter'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => ws_env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) ws_env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | External Debug Mode
    |--------------------------------------------------------------------------
    |
    | When external debug mode enabled, detailed error messages with
    | stack traces will be shown on every error that occurs outside your
    | application. If disabled, error will be ignored.
    |
    */
    'debug_external' => (bool) ws_env('APP_DEBUG_EXTERNAL', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => ws_env('APP_URL', site_url()?:'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Asset Url
    |--------------------------------------------------------------------------
    |
    | This URL is used in ws_asset function to generate url to asset.
    | Default it points to public directory
    |
    */
    'asset_url' => ws_env('ASSET_URL', ws_plugin_url('public')),

    /*
    |--------------------------------------------------------------------------
    | Mix Url
    |--------------------------------------------------------------------------
    |
    | This URL is used in ws_mix function to generate url to asset.
    | Default it points to public directory
    |
    */
    'mix_url' => ws_env('MIX_URL', ws_plugin_url('public')),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. Please keep this
    | as 'UTC' because it will conflict with WordPress if using another value
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => function_exists('determine_locale')?determine_locale():'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the WpStarter encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => ws_env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * WpStarter Framework Service Providers...
         */
        WpStarter\Auth\AuthServiceProvider::class,
        WpStarter\Broadcasting\BroadcastServiceProvider::class,
        WpStarter\Bus\BusServiceProvider::class,
        WpStarter\Cache\CacheServiceProvider::class,
        WpStarter\Foundation\Providers\ConsoleSupportServiceProvider::class,
        WpStarter\Cookie\CookieServiceProvider::class,
        WpStarter\Database\DatabaseServiceProvider::class,
        WpStarter\Encryption\EncryptionServiceProvider::class,
        WpStarter\Filesystem\FilesystemServiceProvider::class,
        WpStarter\Foundation\Providers\FoundationServiceProvider::class,
        WpStarter\Hashing\HashServiceProvider::class,
        WpStarter\Mail\MailServiceProvider::class,
        WpStarter\Notifications\NotificationServiceProvider::class,
        WpStarter\Pagination\PaginationServiceProvider::class,
        WpStarter\Pipeline\PipelineServiceProvider::class,
        WpStarter\Queue\QueueServiceProvider::class,
        WpStarter\Redis\RedisServiceProvider::class,
        WpStarter\Session\SessionServiceProvider::class,
        WpStarter\Translation\TranslationServiceProvider::class,
        WpStarter\Validation\ValidationServiceProvider::class,
        WpStarter\View\ViewServiceProvider::class,
        WpStarter\Wordpress\WordpressServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Admin\AdminServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => WpStarter\Support\Facades\App::class,
        'Arr' => WpStarter\Support\Arr::class,
        'Artisan' => WpStarter\Support\Facades\Artisan::class,
        'Auth' => WpStarter\Support\Facades\Auth::class,
        'Blade' => WpStarter\Support\Facades\Blade::class,
        'Broadcast' => WpStarter\Support\Facades\Broadcast::class,
        'Bus' => WpStarter\Support\Facades\Bus::class,
        'Cache' => WpStarter\Support\Facades\Cache::class,
        'Config' => WpStarter\Support\Facades\Config::class,
        'Cookie' => WpStarter\Support\Facades\Cookie::class,
        'Crypt' => WpStarter\Support\Facades\Crypt::class,
        'Date' => WpStarter\Support\Facades\Date::class,
        'DB' => WpStarter\Support\Facades\DB::class,
        'Eloquent' => WpStarter\Database\Eloquent\Model::class,
        'Event' => WpStarter\Support\Facades\Event::class,
        'File' => WpStarter\Support\Facades\File::class,
        'Gate' => WpStarter\Support\Facades\Gate::class,
        'Hash' => WpStarter\Support\Facades\Hash::class,
        'Http' => WpStarter\Support\Facades\Http::class,
        'Js' => WpStarter\Support\Js::class,
        'Lang' => WpStarter\Support\Facades\Lang::class,
        'Log' => WpStarter\Support\Facades\Log::class,
        'Mail' => WpStarter\Support\Facades\Mail::class,
        'Notification' => WpStarter\Support\Facades\Notification::class,
        'Password' => WpStarter\Support\Facades\Password::class,
        'Queue' => WpStarter\Support\Facades\Queue::class,
        'RateLimiter' => WpStarter\Support\Facades\RateLimiter::class,
        'Redirect' => WpStarter\Support\Facades\Redirect::class,
        // 'Redis' => WpStarter\Support\Facades\Redis::class,
        'Request' => WpStarter\Support\Facades\Request::class,
        'Response' => WpStarter\Support\Facades\Response::class,
        'Route' => WpStarter\Support\Facades\Route::class,
        'Schema' => WpStarter\Support\Facades\Schema::class,
        'Session' => WpStarter\Support\Facades\Session::class,
        'Storage' => WpStarter\Support\Facades\Storage::class,
        'Str' => WpStarter\Support\Str::class,
        'URL' => WpStarter\Support\Facades\URL::class,
        'Validator' => WpStarter\Support\Facades\Validator::class,
        'View' => WpStarter\Support\Facades\View::class,

    ],

];
