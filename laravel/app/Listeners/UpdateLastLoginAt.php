<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function handle(Login $event)
    {
        $event->user->forceFill(['last_login_at' => now()])->save();
    }
}