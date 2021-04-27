<?php

namespace Increment\Common\Notification\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Increment\Imarket\Location\Models\Location;
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

    public function retrieveSynqtNotification(Request $request) {

      $synqtClass = 'App\Http\Controllers\SynqtController';
      $merchantClass = 'Increment\Imarket\Merchant\Http\MerchantController';

      $data = $request->all();
      $this->model = new Notification();
      $this->retrieveDB($data);
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          $result[$i]['reservee'] = $this->retrieveNameOnly($result[$i]['from']);
          $result[$i]['synqt'] = app($synqtClass)->retrieveByParams('id', $result[$i]['payload_value']);
          $result[$i]['location'] = Location::where('id', '=', app($synqtClass)->retrieveByParams('id', $result[$i]['payload_value'])[0]->location_id)->get();
          $result[$i]['merchant'] = app($merchantClass)->getByParams('id', $result[$i]['location'][0]->merchant_id);
          $result[$i]['members'] = app('Increment\Messenger\Http\MessengerGroupController')->getMembersByParams('payload', $result[$i]['payload_value'], ['id', 'title']);
          $i++;
        }
        $this->response['data'] = $result;
      }
      return $this->response();
    }

    public function retrieve(Request $request){
      $data = $request->all();
      $this->model = new Notification();
      $this->retrieveDB($data);
      $size = 0;
      $flag = false;
      $result = $this->response['data'];
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

    public function retrieveNew(Request $request){
      $data = $request->all();
      $this->model = new Notification();
      $this->retrieveDB($data);
      $size = 0;
      $flag = false;
      $result = $this->response['data'];
      if(sizeof($result) > 0){
        $i = 0;
        foreach ($result as $key) {
          if($flag == false && $result[$i]['updated_at'] == null){
            $size++;
          }else if($flag == false && $result[$i]['updated_at'] != null){
            $flag = true;
          }
          $result[$i] = $this->manageResultNew($result[$i], false);
          $i++;
        }
      }
      return response()->json(array(
        'data' => sizeof($result) > 0 ? $result : null,
        'size' => $size
      ));
    }

    public function retrieveByRequest($id){
      $this->response['data'] = Notification::where('id', '=', $id)->get();
      $size = 0;
      $flag = false;
      $result = $this->response['data'];
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
      return array($result);
    }
    

    public function manageResult($result, $notify = false){
        $this->localization();
        // $account = $this->retrieveAccountDetailsOnRequests($result['from']);
        $response = null;
        $result['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result['created_at'])->copy()->tz($this->response['timezone'])->format('F j, Y h:i A');

        if($result['payload'] == 'Peer Request'){
          $response = array(
            'message' => "There is new processing proposal to your request",
            'title'   => "New peer request",
            'type'    => 'Notifications',
            'topic'   => 'Notifications',
            'payload'    => $result['payload'],
            'payload_value' => $result['payload_value'],
            'route'   => $result['route'],
            'date'    => $result['created_at_human'],
            'id'      => $result['id'],
            // 'from'    => $result['from'],
            'to'      => $result['to']
          );
        }else if($result['payload'] == 'thread'){
          $response = array(
            'message' => "Your proposal was accepted",
            'title'   => "New Thread Message",
            'type'    => 'notifications',
            'topic'   => 'notifications',
            'payload'    => $result['payload'],
            'payload_value' => $result['payload_value'],
            'route'   => $result['route'],
            'date'    => $result['created_at_human'],
            'id'      => $result['id'],
            // 'from'    => $result['from'],
            'to'      => $result['to']
          );
        }else{
          $response = array(
            'message' => 'View Activity',
            'title'   => $result['payload'],
            'type'    => 'notifications',
            'topic'   => 'notifications',
            'payload'    => $result['payload'],
            'payload_value' => $result['payload_value'],
            'route'   => $result['route'],
            'date'    => $result['created_at_human'],
            'id'      => $result['id'],
            // 'from'    => $result['from'],
            'to'      => $result['to']
          );
        }
        if($notify == false){
          $response['from'] = $result['from'];
        }
        if($notify == true && $response != null){
          Notifications::dispatch('notifications', $response);
        }
        return $response;
    }

    public function manageResultNew($result, $notify = false){
      $this->localization();
      // $account = $this->retrieveAccountDetailsOnRequests($result['from']);
      $response = null;
      $result['created_at_human'] = Carbon::createFromFormat('Y-m-d H:i:s', $result['created_at'])->copy()->tz($this->response['timezone'])->format('F j, Y h:i A');

      if($result['payload'] == 'Peer Request'){
        $response = array(
          'message' => "There is new processing proposal to your request",
          'title'   => "New peer request",
          'type'    => 'Notifications',
          'topic'   => 'Notifications',
          'payload'    => $result['payload'],
          'payload_value' => $result['payload_value'],
          'route'   => $result['route'],
          'date'    => $result['created_at_human'],
          'id'      => $result['id'],
          // 'from'    => $result['from'],
          'request' => app('App\Http\Controllers\RequestMoneyController')->retrieveByPayloadValue($result['payload_value']),
          'to'      => $result['to']
        );
      }else if($result['payload'] == 'thread'){
        $response = array(
          'message' => "Your proposal was accepted",
          'title'   => "New Thread Message",
          'type'    => 'notifications',
          'topic'   => 'notifications',
          'payload'    => $result['payload'],
          'payload_value' => $result['payload_value'],
          'route'   => $result['route'],
          'date'    => $result['created_at_human'],
          'id'      => $result['id'],
          // 'from'    => $result['from'],
          'currency' => app('App\Http\Controllers\RequestMoneyController')->getByParamsWithColumns('id' ,$result['payload_value'], ['currency']),
          'amount' => app('App\Http\Controllers\RequestMoneyController')->getByParamsWithColumns('id' ,$result['payload_value'], ['amount']),
          'to'      => $result['to']
        );
      }else{
        $response = array(
          'message' => 'View Activity',
          'title'   => $result['payload'],
          'type'    => 'notifications',
          'topic'   => 'notifications',
          'payload'    => $result['payload'],
          'payload_value' => $result['payload_value'],
          'route'   => $result['route'],
          'date'    => $result['created_at_human'],
          'id'      => $result['id'],
          // 'from'    => $result['from'],
          'to'      => $result['to']
        );
      }
      if($notify == false){
        $response['from'] = $result['from'];
      }
      if($notify == true && $response != null){
        Notifications::dispatch('notifications', $response);
      }
      return $response;
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
