<?php
use WpStarter\Http\Request;
use WpStarter\Wordpress\Plugins\Loader as PluginsLoader;

final class WordpressStarter
{
    /**
     * Default hook to handle WpStarter request
     * We use WordPress init hook and priority is 1 for better performance.
     * However, it's possible that we may miss some initializations from other plugins.
     * In such cases, we can consider moving to a lower priority by using
     * a higher number than the default value in WordPress, for example, 11.
     * @var int
     */
    protected $defaultHook='init:1';
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
        if($this->isRunningInConsole()) {//Cli only handle once at default hook
            $hook=$this->parseHook($this->defaultHook);
            add_action($hook[0], [$this, 'handleCli'], $hook[1]);
        }else{
            //After application booted and all routes registered, we can register web handler
            add_action('ws_booted',[$this,'registerWebHandler']);
        }
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
            $this->initWeb();
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
    /**
     * Init the web request
     * @return void
     */
    function initWeb(){
        $this->checkMaintenance();
        $request = Request::capture();
        //Temporary setup new request for earlybootstrap and plugins loader
        $this->app->instance('request.main', $request);
        $this->app->instance('request', $request);
    }
    function bootCore(){
        $this->kernel->earlyBootstrap();
        $this->bootPluginsLoader();

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
        do_action('ws_booted',$this->app,$this->kernel);
    }

    /**
     * Register multiple hooks web handler
     * @return void
     */
    function registerWebHandler(){
        if(is_admin()){
            return ;
        }
        $hooks=[$this->defaultHook];
        $hooks=array_merge($hooks,$this->getHooksFromRoutes($this->app['router']->getRoutes()));
        //$hooks=array_merge($hooks,$this->getHooksFromRoutes($this->app['wp.router']->getRoutes()));
        $hooks=array_unique($hooks);
        foreach ($hooks as $hook){
            $hook=$this->parseHook($hook);
            add_action($hook[0],[$this,'handleWeb'],$hook[1]);
        }
    }
    protected function getHooksFromRoutes(\WpStarter\Routing\RouteCollection $routes){
        $hooks=[];
        foreach ($routes->getRoutes() as $route){
            if($hook=$route->getAction('hook')){
                $hooks[]=$hook;
            }
        };
        return $hooks;
    }


    /**
     * Handle cli application
     * @return void
     */
    public function handleCli()
    {
        //Cli will be handled from artisan
    }

    /**
     * Handle web application
     * @return void
     */
    public function handleWeb()
    {
        $this->kernel->handle(
            Request::capture(), true
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

    protected function parseHook($hook){
        if(!is_array($hook)){
            $hook=explode(':',$hook);
        }
        if(!isset($hook[0])){
            $hook[0]='init';
        }
        if(!isset($hook[1])){
            $hook[1]=10;
        }
        $hook[1]=intval($hook[1]);
        return $hook;
    }
}