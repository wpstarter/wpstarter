<?php
use WpStarter\Http\Request;
final class WordpressStarter
{
    /**
     * @var \WpStarter\Foundation\Application
     */
    protected $app;
    /**
     * @var WpStarter\Wordpress\Kernel | WpStarter\Wordpress\Console\Kernel
     */
    protected $kernel;
    static protected $instance;

    public static function make()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct()
    {
        $this->loadApp();
    }
    function loadApp(){
        if(!$this->app) {
            require __DIR__ . '/bootstrap/autoload.php';
            return $this->app = require_once __DIR__ . '/bootstrap/app.php';
        }
        return $this->app;
    }
    public function app(){
        return $this->app;
    }
    public function kernel(){
        return $this->kernel;
    }
    function run(){
        if ($this->isRunningInConsole()) {
            $this->runCli();
        } else {
            $this->runWeb();
        }
        if(!did_action('mu_plugin_loaded')) {
            add_action('mu_plugin_loaded', [$this->kernel, 'earlyBootstrap'], 1);
        }else{
            add_action('ws_loaded',[$this->kernel,'earlyBootstrap'],1);
        }
        add_action('plugins_loaded',[$this->kernel,'bootstrap'],1);
        do_action('ws_loaded',$this);
    }


    protected function isRunningInConsole(){
        if(defined('WS_CLI') && WS_CLI){
            return true;
        }
        if(defined('WP_CLI') && WP_CLI){
            return true;
        }
        if (isset($_ENV['APP_RUNNING_IN_CONSOLE'])) {
            return $_ENV['APP_RUNNING_IN_CONSOLE'] === 'true';
        }
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

    protected function runCli()
    {
        $this->kernel = $this->app->make(WpStarter\Contracts\Console\Kernel::class);
    }


    protected function runWeb()
    {
        $this->checkMaintenance();
        $this->kernel = $kernel = $this->app->make(WpStarter\Contracts\Http\Kernel::class);
        $request = Request::capture();
        $this->app->instance('request', $request);
        add_action('init', function ()use($kernel,$request) {
            $response = $kernel->handle(
                $request
            );
        }, 1);

    }


    /**
     * Check If The Application Is Under Maintenance
     * If the application is in maintenance / demo mode via the "down" command
     * we will load this file so that any pre-rendered content can be shown
     * instead of starting the framework, which could cause an exception.
     * @return void
     */
    protected function checkMaintenance(){
        if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
            require $maintenance;
        }
    }
}