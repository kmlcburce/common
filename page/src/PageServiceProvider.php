<?php

namespace Increment\Common\Page;

use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider{
  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}