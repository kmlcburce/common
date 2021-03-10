<?php

namespace Increment\Common\MyCircle;

use Illuminate\Support\ServiceProvider;

class MyCircleServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}