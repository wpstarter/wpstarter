<?php

namespace App\View\Components;

use WpStarter\Wordpress\View\Component;

class Welcome extends Component
{
    function mount()
    {
        $this->getResponse()->withTitle('abc');
        $this->response->withPostTitle('Post title');
        //dd($this->response);
    }

    public function render()
    {
        return ws_view('welcome');
    }
}