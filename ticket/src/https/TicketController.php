<?php

namespace Increment\Common\Ticket\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Ticket\Models\Ticket;

class TicketController extends Controller
{
    //
    function __construct(){
        if($this->checkAuthenticatedUser() == false){
          return $this->response();
        }
        $this->model = new Payload();
        $this->notRequired = array('assigned_to');
      }
}
