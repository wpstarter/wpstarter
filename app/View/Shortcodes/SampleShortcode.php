<?php

namespace App\View\Shortcodes;

use WpStarter\Http\Request;
use WpStarter\Wordpress\Facades\L10n;
use WpStarter\Wordpress\View\Shortcode;

class SampleShortcode extends Shortcode
{
    protected $tag='sample-shortcode';

    public function render()
    {
        return 'Im a sample shortcode with content: '.$this->content.' and attributes '.json_encode($this->attributes).
            __('hello world','app').'<br>'.'If you do not want to pass domain you can use '.L10n::__('translate me').' which default to loaded domain';
    }
}