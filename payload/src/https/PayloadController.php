<?php

namespace Increment\Common\Payload\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Increment\Common\Payload\Models\Payload;
use Increment\Common\Image\Models\Image;
class PayloadController extends APIController
{
    function __construct(){
      if($this->checkAuthenticatedUser() == false){
        return $this->response();
      }
      $this->model = new Payload();
    }

    public function uploadValidId(Request $request){
      $data = $request->all();
      $payloadValue = array();
      $payloadValue['url'] = $data['file_url'];
      $payloadValue['status'] = 'PENDING';
      $data['payload'] = 'valid_id';
      $data['payload_value'] = $payloadValue;
      $this->model = new Payload();
      $this->insertDB($data);
      return $this->response();
    }
    
    public function checkValidId(Request $request){
      $data=$request->all();
      $id = Payload::where('account_id','=',$data['account_id'])
            ->where('payload','=', 'valid_id')
            ->get();
      return $id;
    }
}
