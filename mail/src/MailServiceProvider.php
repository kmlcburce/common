<?php

namespace Increment\Common\Mail;

use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider{

  public function boot(){
    $this->loadRoutesFrom(__DIR__.'/routes/web.php');
  }

  public function register(){
  }
}