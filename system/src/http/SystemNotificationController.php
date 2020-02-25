<?php

namespace Increment\Common\System\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Common\System\Models\SystemNotification;
use App\Http\Controllers\APIController;
use App\Jobs\Notifications;
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
      if($this->response['data'] > 0){
        $data['id'] = $this->response['data'];
        Notifications::dispatch('system_notification', $data);
      }
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
