<?php

namespace Increment\Common\Payload\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Payload\Models\Payload;
class PayloadController extends APIController
{
    function __construct(){
      if($this->checkAuthenticatedUser() == false){
        return $this->response();
      }
      
      $this->model = new Payload();
    }
}
