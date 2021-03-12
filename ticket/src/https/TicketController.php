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
        $this->notRequired = array('assigned_to', 'images');
      }
    
    public function generateCode(){
      $code = 'tic_'.substr(str_shuffle($this->codeSource), 0, 60);
      $codeExist = Ticket::where('id', '=', $code)->get();
      if(sizeof($codeExist) > 0){
        $this->generateCode();
      }else{
        return $code;
      }
    }

    public function create(Request $request){
      $data = $request->all();
      $data['code'] = $this->generateCode();
      $data['status'] = 'PENDING';
      $this->model = new Ticket();
      $this->insertDB($data);
      return $this->response();
    }

    public function resolveTicket(Request $request){
      //check authenticated user
      //TODO: add authentication here
      $data = $request->all();
      $result = Ticket::where('code', '=', $data['code'])->update(array('status' => 'CLOSED'));
      $this->response['data'] = $result ? true : false;
      return $this->response();
    }
}
