<?php

namespace Increment\Common\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadMigrationsFrom(__DIR__.'/migrations');
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}