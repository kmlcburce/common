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
      $size = 0;
      $flag = false;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          if($flag == false && $result[$i]['updated_at'] == null){
            $size++;
          }
          if($flag == false && $result[$i]['updated_at'] != null){
            $flag = true;
          }
          $result[$i]['account'] = $this->retrieveAccountDetails($result[$i]['from']);
          $result[$i]['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result[$i]['created_at'])->copy()->tz('Asia/Manila')->format('F j, Y');
          if($result[$i]['payload'] == 'guarantor'){
            $result[$i]['title'] = 'Guarantor Notification';
            $result[$i]['description'] = 'You have been assigned as guarantor by '.$result[$i]['account']['username'];
          }else if($result[$i]['payload'] == 'comaker'){
            $result[$i]['title'] = 'Comaker Notification';
            $result[$i]['description'] = 'You have been assigned as comaker by '.$result[$i]['account']['username'];
          }else if($result[$i]['payload'] == 'mail'){
            $result[$i]['title'] = 'Mail Notification';
            $result[$i]['description'] = 'An email has been sent to your email address';
          }else if($result[$i]['payload'] == 'invest'){
            $result[$i]['title'] = 'Investment Notification';
            $result[$i]['description'] = 'You have received a new investment from'.$result[$i]['account']['username'];
          }
          $i++;
        }
      }
      return response()->json(array(
        'data' => sizeof($result) > 0 ? $result : null,
        'size' => sizeof($size)
      ));
    }

    public function update(Request $request){
      $data = $request->all();
      $data['updated_at'] = Carbon::now();
      $this->model = new Notification();
      $this->updateDB($data);
      return $this->response();
    }

    public function createByParams($parameter){
      Notification::insert($parameter);
      return true;
    }
}
