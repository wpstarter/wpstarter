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

    protected $booted;
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
        $this->boot();
    }

    /**
     * Create application and kernel based on current env
     * Will try to bootstrap application when it runs inside WordPress
     * by this way we can make sure application bootstrap run at correct point
     * @return void
     */
    function boot(){
        if($this->booted){
            return;
        }
        $this->booted=true;
        $this->app = require_once WS_DIR . '/bootstrap/app.php';
        if ($this->isRunningInConsole()) {
            $this->kernel = $this->app->make(WpStarter\Contracts\Console\Kernel::class);
        }else{
            $this->kernel = $this->app->make(WpStarter\Contracts\Http\Kernel::class);
        }
        if(!function_exists('add_action')){
            //No WordPress env, skip register bootstrap
            return ;
        }
        if(!did_action('mu_plugin_loaded')) {
            add_action('mu_plugin_loaded', [$this->kernel, 'earlyBootstrap'], 1);
        }else{
            add_action('ws_loaded',[$this->kernel,'earlyBootstrap'],1);
        }
        add_action('plugins_loaded',[$this->kernel,'bootstrap'],1);
        do_action('ws_loaded',$this);
    }
    public function app(){
        return $this->app;
    }
    public function kernel(){
        return $this->kernel;
    }
    function run(){
        $this->boot();
        if ($this->isRunningInConsole()) {
            $this->runCli();
        } else {
            $this->runWeb();
        }

    }

    protected function runCli()
    {
        //Nothing to run here
    }


    protected function runWeb()
    {
        $this->checkMaintenance();
        $request = Request::capture();
        $this->app->instance('request', $request);
        add_action('init', function ()use($request) {
            $response = $this->kernel->handle(
                $request
            );
        }, 1);

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

    /**
     * Check If The Application Is Under Maintenance
     * If the application is in maintenance / demo mode via the "down" command
     * we will load this file so that any pre-rendered content can be shown
     * instead of starting the framework, which could cause an exception.
     * @return void
     */
    protected function checkMaintenance(){
        if (file_exists($maintenance = WS_DIR.'/storage/framework/maintenance.php')) {
            require $maintenance;
        }
    }
}