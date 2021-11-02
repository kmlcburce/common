<?php

namespace Increment\Common\Invitation;

use Illuminate\Support\ServiceProvider;

class InvitationServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}