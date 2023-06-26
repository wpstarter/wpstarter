<?php
use WpStarter\Http\Request;
use WpStarter\Wordpress\Plugins\Loader as PluginsLoader;

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

    /**
     * Create instance of WpStarter
     * @return self
     */
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
        $this->app = require WS_DIR . '/bootstrap/app.php';
        if ($this->isRunningInConsole()) {
            $this->kernel = $this->app->make(WpStarter\Contracts\Console\Kernel::class);
        }else{
            $this->kernel = $this->app->make(WpStarter\Contracts\Http\Kernel::class);
        }
        if(class_exists(PluginsLoader::class)){
            $this->checkForPluginsLoader();
            PluginsLoader::getInstance()->run();
        }
        add_action('ws_loaded',[$this->kernel,'earlyBootstrap'],1);
        add_action('plugins_loaded',[$this->kernel,'bootstrap'],1);
        if(!did_action('mu_plugin_loaded')) {
            add_action('mu_plugin_loaded', function (){
                do_action('ws_loaded',$this);
            }, 1);
        }else{
            do_action('ws_loaded',$this);
        }
    }

    /**
     * Get the application
     * @return \WpStarter\Foundation\Application
     */
    public function app(){
        //Instance may be lost when create new application
        $this->app::setInstance($this->app);
        return $this->app;
    }

    /**
     * Get the kernel
     * @return \WpStarter\Wordpress\Console\Kernel|\WpStarter\Wordpress\Kernel
     */
    public function kernel(){
        return $this->kernel;
    }

    /**
     * Run WpStarter Application
     * @return void
     */
    function run(){
        $this->boot();
        if ($this->isRunningInConsole()) {
            $this->runCli();
        } else {
            $this->runWeb();
        }

    }

    function checkForPluginsLoader(){
        if (file_exists($loader = WS_DIR.'/app/PluginsLoader.php')) {
            require $loader;
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
             $this->kernel->handle(
                $request, true
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