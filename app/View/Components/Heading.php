<?php

namespace App\View\Components;

use WpStarter\Contracts\Support\Renderable;

class Heading implements Renderable
{
    public function render()
    {
        return 'Welcome title';
    }
}