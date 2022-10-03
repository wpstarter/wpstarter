<?php

namespace App\Console\Commands;

use WpStarter\Console\Command;
use WpStarter\Support\Facades\DB;
use WpStarter\Wordpress\User;

class TestCommand extends Command
{
    protected $signature='test';
    function handle(){
        $query=User::findBy('ID',1);
        $user=$query->first();
        if($user instanceof User) {
            $user->update(['first_name'=>'abc','user_pass'=>'*FG3m&6cxiy(aGb*ov']);
            print_r($user->getChanges());
        }
        dd($user->getAttribute('a-b'));
    }
}