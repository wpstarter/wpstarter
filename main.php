<?php
/***
 * Plugin name: WpStarter
 * Version:     1.0
 * Description: WpStarter Plugin
 * Author:      As247
 * Author URI:  https://github.com/as247
 *
 */
if(defined('__WS_FILE__')){
    return ;
}
define('WS_VERSION', '1.0');
define('WS_DIR', __DIR__);
define('__WS_FILE__', __FILE__);

require __DIR__ . '/bootstrap/autoload.php';
use WpStarter\Http\Request;
final class WordpressStarter
{
	protected $app;
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
		$this->app = require_once __DIR__ . '/bootstrap/app.php';
	}


	function run()
	{
		if ($this->isRunningInConsole()) {
			$this->runCli();
		} else {
			$this->runWeb();
		}
	}

	protected function isRunningInConsole(){
        if(defined('SW_CLI') && SW_CLI){
            return true;
        }
        if(defined('WP_CLI') && WP_CLI){
            return true;
        }
        if (isset($_ENV['APP_RUNNING_IN_CONSOLE'])) {
            return $_ENV['APP_RUNNING_IN_CONSOLE'] === 'true';
        }
        if(defined('SW_WEB_REQUEST') && SW_WEB_REQUEST){//Force web request
            return false;
        }
        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

	protected function runCli()
	{
		$kernel = $this->app->make(WpStarter\Contracts\Console\Kernel::class);
        //add_action('sw_early_bootstrap',[$kernel,'earlyBootstrap'],0);
        add_action('plugins_loaded',[$kernel,'bootstrap'],1);
		if(defined('WS_CLI') && WS_CLI) {
            add_action('init', function () use ($kernel) {
                $status = $kernel->handle(
                    $input = new Symfony\Component\Console\Input\ArgvInput,
                    new Symfony\Component\Console\Output\ConsoleOutput
                );
                $kernel->terminate($input, $status);

                exit($status);
            }, 110);
        }
        do_action('sw_early_bootstrap');
	}


	protected function runWeb()
	{
        $kernel = $this->app->make(WpStarter\Contracts\Http\Kernel::class);
        $request = Request::capture();
        $this->app->instance('request', $request);
        add_action('plugins_loaded',[$kernel,'bootstrap'],1);
	    add_action('init', function ()use($kernel,$request) {
            $response = $kernel->handle(
                $request
            );
            $this->processWebResponse($kernel,$request,$response);
		}, 1);
        do_action('sw_early_bootstrap');

	}

    protected function processWebResponse($kernel,$request,$response){
        //Check to make sure 404 not raised by route
        if(!$request->isNotFoundHttpExceptionFromRoute()){
            if($response instanceof \WpStarter\Wordpress\Response){
                //Got a WordPress response, process it
                $handler=$this->app->make(WpStarter\Wordpress\Response\Handler::class);
                $handler->handle($kernel,$request,$response);
            }else {
                $response->send();
                $kernel->terminate($request, $response);
                die;
            }
        }
    }
}
if(!wp_installing()) {
    WordpressStarter::make()->run();
}

