<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\Models\User;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('users', function () {
    
    $users = User::all();
    
    foreach ($users as $user) {
        echo "{$user -> first_name} {$user -> last_name} --- {$user -> email} --- {$user -> password}\n";
    }
})->purpose('Display all users');


