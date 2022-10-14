<?php

namespace App\View\Components;

use WpStarter\Wordpress\View\Component;

class Welcome extends Component
{
    /**
     * Call before render
     * @return void
     */
    function mount()
    {
        $this->response->withPostTitle('Post title');
    }

    public function render()
    {
        return ws_view('welcome');
    }
}