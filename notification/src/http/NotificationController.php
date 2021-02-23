<?php

namespace Increment\Common\Notification\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Account\Models\Account;
use Increment\Common\Notification\Models\Notification;
use App\Http\Controllers\APIController;
use App\Jobs\Notifications;
class NotificationController extends APIController
{
    function __construct(){
      if($this->checkAuthenticatedUser() == false){
        return $this->response();
      }
      $this->model = new Notification();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $result = Notification::where('to', '=', $data['account_id'])->orderBy('created_at', 'desc')->get();
      $size = 0;
      $flag = false;
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          if($flag == false && $result[$i]['updated_at'] == null){
            $size++;
          }else if($flag == false && $result[$i]['updated_at'] != null){
            $flag = true;
          }
          $result[$i] = $this->manageResult($result[$i], false);
          $i++;
        }
      }
      return response()->json(array(
        'data' => sizeof($result) > 0 ? $result : null,
        'size' => $size
      ));
    }

    public function manageResult($result, $notify = false){
        $this->localization();
        $account = $this->retrieveAccountDetailsOnRequests($result['from']);
        $result['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result['created_at'])->copy()->tz($this->response['timezone'])->format('F j, Y h:i A');
        if($result['payload'] == 'guarantor'){
          $result['title'] = 'Guarantor Notification';
          $result['message'] = 'You have been assigned as guarantor by '.$account['username'];
        }else if($result['payload'] == 'comaker'){
          $result['title'] = 'Comaker Notification';
          $result['message'] = 'You have been assigned as comaker by '.$account['username'];
        }else if($result['payload'] == 'mail'){
          $result['title'] = 'Mail Notification';
          $result['message'] = 'An email has been sent to your email address';
        }else if($result['payload'] == 'invest'){
          $result['title'] = 'Investment Notification';
          $result['message'] = 'You have received a new investment from '.$account['username'];
        }else if($result['payload'] == 'request'){
          $result['title'] = 'Request Notification';
          $result['message'] = 'You have received a peer request from '.$account['username'];
        }else if($result['payload'] == 'thread'){
          $result['title'] = 'Thread Notification';
          $result['message'] = 'You have received a message thread from '.$account['username'];
        }else if($result['payload'] == 'ledger'){
          $result['title'] = 'Ledger Notification';
          $result['message'] = 'You have an activity with your ledger.';
        }else if($result['payload'] == 'new_delivery'){
          $result['title'] = 'Delivery';
          $result['message'] = 'New rider found! Click for more details.';
        }else if(explode('/', $result['payload'])[0] == 'form_request' && explode('/', $result['payload'])[1] == 'customer'){
          $result['title'] = 'Customer Health Declaration Form';
          $result['message'] = 'You need to fill up the health declaration form.';
        }else if(explode('/', $result['payload'])[0] == 'form_request' && explode('/', $result['payload'])[1] == 'employee_checkin'){
          $result['title'] = 'Checkin Health Declaration Form';
          $result['message'] = 'You need to fill up the health declaration form.';
        }else if(explode('/', $result['payload'])[0] == 'form_request' && explode('/', $result['payload'])[1] == 'employee_checkout'){
          $result['title'] = 'Checkout Health Declaration Form';
          $result['message'] = 'You need to fill up the health declaration form.';
        }else if(explode('/', $result['payload'])[0] == 'form_submitted' && explode('/', $result['payload'])[1] == 'customer'){
          $result['title'] = 'Health Declaration Form';
          $result['message'] = 'Customer form submitted.';
        }else if(explode('/', $result['payload'])[0] == 'form_submitted' && explode('/', $result['payload'])[1] == 'employee_checkin'){
          $result['title'] = 'Health Declaration Form';
          $result['message'] = 'Employee checkin form submitted.';
        }else if(explode('/', $result['payload'])[0] == 'form_submitted' && explode('/', $result['payload'])[1] == 'employee_checkout'){
          $result['title'] = 'Health Declaration Form';
          $result['message'] = 'Employee checkout form submitted.';
        }else if($result['payload'] == 'installment'){
          $result['title'] = 'Installment Notification';
          $result['message'] = 'You have an activity on your installment.';
        }else if($result['payload'] == 'rental'){
          $result['tilte'] = 'Rental Notification';
          $result['message'] = 'You have an activity on your rental.';
        }else if($result['payload'] == 'Peer Request'){
          $result['message'] = "There's new processing proposal to your request";
          $result['title'] = 'New peer request';
          $result['type'] = 'Notifications';
          $result['topic'] = 'Notifications';
        }else{
          // $result['title'] = 'Notification';
          // $result['description'] = 'You have an activity with your ledger.';
        }
        if($notify == true){
          Notifications::dispatch('notifications', $result);
        }
        return $result;
    }

    public function update(Request $request){
      $data = $request->all();
      Notification::where('id', '=', $data['id'])->update(array(
        'updated_at' => Carbon::now()
      ));
      $this->response['data'] = true;
      return $this->response();
    }

    public function createByParams($parameter){
      $model = new Notification();
      $model->from = $parameter['from'];
      $model->to = $parameter['to'];
      $model->payload = $parameter['payload'];
      $model->payload_value = $parameter['payload_value'];
      $model->route = $parameter['route'];
      $model->created_at = $parameter['created_at'];
      $model->updated_at = null;
      $model->save();
      $result = Notification::where('id', '=', $model->id)->get();
      $this->manageResult($result[0], true);
      return true;
    }
}
