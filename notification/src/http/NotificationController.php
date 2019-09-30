<?php

namespace Increment\Common\Notification\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Account\Models\Account;
use Increment\Common\Notification\Models\Notification;
use App\Http\Controllers\APIController;
class NotificationController extends APIController
{
    function __construct(){
      $this->model = new Notification();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $result = Notification::where('to', '=', $data['account_id'])->get();
      $size =  Notification::where('to', '=', $data['account_id'])->get();
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['account'] = $this->retrieveAccountDetails($result[$i]['from']);
          $result[$i]['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['created_at'])->copy()->tz('Asia/Manila')->format('F j, Y');
          if($result[$i]['payload'] == 'guarantor'){
            $result[$i]['display'] = 'You have been assigned as guarantor by '.$result[$i]['account']['username'];
          }
          else if($result[$i]['payload'] == 'mail'){
            $result[$i]['display'] = 'An email has been sent to your email address';
          }
          else if($result[$i]['payload'] == 'invest'){
            $result[$i]['display'] = 'You have received a new investment from'.$result[$i]['account']['username'];
          }
          $i++;
        }
      }
      return response()->json(array(
        'data' => sizeof($result) > 0 ? $result : null,
        'size' => sizeof($size)
      ));
    }
}
