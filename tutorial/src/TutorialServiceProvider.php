<?php

namespace Increment\Common\Tutorial;

use Illuminate\Support\ServiceProvider;

class TutorialServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}