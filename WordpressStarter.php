<?php
use WpStarter\Http\Request;
use WpStarter\Wordpress\Plugins\Loader as PluginsLoader;

final class WordpressStarter
{
    /**
     * Run priority at init hook, default is 1 for better performance.
     * However, it's possible that we may miss some initializations from other plugins.
     * In such cases, we can consider moving to a lower priority by using
     * a higher number than the default value in WordPress, for example, 11.
     * @var int
     */
    protected $priority=1;
    /**
     * @var \WpStarter\Foundation\Application
     */
    protected $app;
    /**
     * @var WpStarter\Wordpress\Kernel | WpStarter\Wordpress\Console\Kernel
     */
    protected $kernel;
    /**
     * @var boolean flag that WpStarter is booted or not
     */
    protected $booted;

    /**
     * @var WordpressStarter hold instance of WordpressStarter
     */
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
     * Run WpStarter Application
     * @return void
     */
    function run(){
        $this->boot();
        add_action('init',[$this,'handle'],$this->priority);
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
        if(!$this->isRunningInConsole()){
            $this->bootWeb();
        }
        add_action('ws_loaded',[$this,'bootCore'],1);
        add_action('plugins_loaded',[$this,'bootKernel'],1);
        if(!did_action('mu_plugin_loaded')) {
            add_action('mu_plugin_loaded', function (){
                do_action('ws_loaded',$this);
            }, 1);
        }else{
            do_action('ws_loaded',$this);
        }
    }
    function bootCore(){
        $this->kernel->earlyBootstrap();
        $this->bootPluginsLoader();

    }
    /**
     * Boot the web part
     * @return void
     */
    function bootWeb(){
        $this->checkMaintenance();
        $request = Request::capture();
        $this->app->instance('request', $request);
    }
    /**
     * Run kernel bootstrap
     * @return void
     */
    function bootKernel(){
        /**
         * ws_boot run before kernel bootstrap to allow third-party plugins register a custom provider
         */
        do_action('ws_boot',$this->app,$this->kernel);
        $this->kernel->bootstrap();
    }

    /**
     * Main application handler
     * @return void
     */
    function handle(){
        if($this->isRunningInConsole()){
            $this->handleCli();
        }else{
            $this->handleWeb();
        }
    }

    /**
     * Handle cli application
     * @return void
     */
    protected function handleCli()
    {
        //Cli will be handled from artisan
    }

    /**
     * Handle web application
     * @return void
     */
    protected function handleWeb()
    {
        $this->kernel->handle(
            $this->app['request'], true
        );
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
     * Check if application is running in console
     * @return bool
     */
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
     * Check and load PluginsLoader if exists
     * @return void
     */
    protected function bootPluginsLoader(){
        if (class_exists(PluginsLoader::class) && file_exists($loader = WS_DIR.'/app/PluginsLoader.php')) {
            PluginsLoader::getInstance()->run();
            require $loader;
        }
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