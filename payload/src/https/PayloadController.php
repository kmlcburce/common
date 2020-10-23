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
      $values = json_encode($values);
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
      $this->response['data'] = $id;
      return $this->response();
    }

    public function getRiderSchedule(Request $request){
      $data = $request->all();
      //rider schedule json
      //{startTime: string, endTime: string, days: 0123456 <- representing duty days, validity: <- date started using said schedule}
      $values = Payload::where('payload', '=', 'rider_schedule')
                ->where('account_id', '=', $data['account_id'])
                ->get();
      $this->response['data'] = $values;
      return $this->response();
    }

    public function addRiderSchedule(Request $request){
      $data = $request->all();
      $data['payload'] = 'rider_schedule';
      $values = array();
      $values['startTime'] = $request['startTime'];
      $values['endTime'] = $request['endTime'];
      $values['days'] = $request['days'];
      $values['validity'] = $request['validity'];
      $values = json_encode($values);
      $data['payload_values'] = $values;
      $this->model = new Payload();
      $this->insertDB($data);
      return $this->response();
    }

    public function createFaqs(Request $request){
      $data = $request->all();
      $data['payload'] = 'faqs';
      $values = array();
      $values['question'] = $data['question'];
      $values['answer'] = $data['answer'];
      $values = json_encode($values);
      $data['payload_value'] = $values;
      $this->model = new Payload();
      $this->insertDB($data);
      return $this->response();
    }

    public function createCategory(Request $request){
      $data = $request->all();
      $data['payload'] = 'category';
      
      //payload values would look like this
      //american, burger, fries, fastfood
      //payload_id would be linked to category in product same with tags ??
    
    }
}
