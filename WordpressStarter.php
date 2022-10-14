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
        $this->kernel = $kernel = $this->app->make(WpStarter\Contracts\Http\Kernel::class);
        $request = Request::capture();
        $this->app->instance('request', $request);
        add_action('init', function ()use($kernel,$request) {
            $response = $kernel->handle(
                $request
            );
            $this->processWebResponse($kernel,$request,$response);
        }, 1);

    }

    /**
     * @param $kernel WpStarter\Wordpress\Kernel | WpStarter\Wordpress\Console\Kernel
     * @param $request
     * @param $response
     * @return void
     */
    protected function processWebResponse($kernel,$request,$response){
        if(!$request->isNotFoundHttpExceptionFromRoute()){
            //Not a not found response from router
            if($response instanceof \WpStarter\Wordpress\Http\Response){
                //Got a WordPress response, process it
                $handler=$this->app->make(WpStarter\Wordpress\Http\Response\Handler::class);
                $handler->handle($kernel,$request,$response);
            }else {//Normal response
                $response->send();
                $kernel->terminate($request, $response);
                die;
            }
        }else{//No route matched
            $kernel->registerWpHandler();
        }
    }
}