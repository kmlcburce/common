<?php

namespace Increment\Common\System;

use Illuminate\Support\ServiceProvider;

class SystemNotificationServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}