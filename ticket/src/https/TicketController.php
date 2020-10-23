<?php

namespace Increment\Common\Ticket\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Ticket\Models\Ticket;

class TicketController extends APIController
{
    //
    function __construct(){
        if($this->checkAuthenticatedUser() == false){
          return $this->response();
        }
        $this->model = new Ticket();
        $this->notRequired = array('assigned_to');
      }
    
    public function resolveTicket(Request $request){
      //check authenticated user
      //TODO: add authentication here
      // Ticket::where('')
    }
}
