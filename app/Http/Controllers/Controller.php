<?php
namespace App\Http\Controllers;

use WpStarter\Foundation\Validation\ValidatesRequests;

abstract class Controller extends \WpStarter\Routing\Controller
{
    use ValidatesRequests;
}