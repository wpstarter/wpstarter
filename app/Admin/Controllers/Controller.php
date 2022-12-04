<?php

namespace App\Admin\Controllers;

use WpStarter\Foundation\Validation\ValidatesRequests;

abstract class Controller extends \WpStarter\Wordpress\Admin\Routing\Controller
{
    use ValidatesRequests;
}