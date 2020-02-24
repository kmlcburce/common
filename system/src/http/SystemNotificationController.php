<?php

namespace Increment\Common\System\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Common\System\Models\SystemNotification;
use App\Http\Controllers\APIController;
class SystemNotificationController extends APIController
{
    function __construct(){
      $this->model = new SystemNotification();
    }

    public function create(Request $request){
      $data = $request->all();
      $data['code'] = $this->generateCode();
      $this->model = new SystemNotification();
      $this->insertDB($data);
      return $this->response();
    }

    public function generateCode(){
      $code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 32);
      $codeExist = SystemNotification::where('code', '=', $code)->get();
      if(sizeof($codeExist) > 0){
        $this->generateCode();
      }else{
        return $code;
      }
    }
}
