<?php

namespace Increment\Common\Mail\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
class MailController extends APIController
{
  function __construct(){
    if($this->checkAuthenticatedUser() == false){
      return $this->response();
    }
  }
}
