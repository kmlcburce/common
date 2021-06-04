<?php

namespace Increment\Common\MyCircle\Http;

use App\Http\Controllers\APIController;
use Increment\Common\MyCircle\Models\MyCircle;
use Increment\Account\Models\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use Mail;

class MyCircleController extends APIController
{
   public $ratingClass = 'Increment\Common\Rating\Http\RatingController';

   function __construct()
   {
      $this->model = new MyCircle();
   }

   public function create(Request $request)
   {
      $data = $request->all();
      $recipient = null;
      if (!isset($data['to_code'])) {
         $recipient = Account::where('email', '=', $data['to_email'])->get();
      } else {
         $recipient = Account::where('code', '=', $data['to_code'])->get();
      }
      $exist = $this->checkIfExist($data['to_email'], $data['account_id']);
      if ($exist == false) {
         $user = $this->retrieveAccountDetails($data['account_id']);
         $insertData = array(
            'code' => $this->generateCode(),
            'account_id'   => $data['account_id'],
            'account'   => $recipient[0]['id'],
            'status'   => 'pending'
         );
         $this->model = new MyCircle();
         $this->insertDB($insertData);
         $data['details']['code'] = $insertData['code'];
         $data['details'] = json_decode(json_encode($data['details']), false);
         // dd(json_decode(json_encode($data['details']), false));
         // dd($data);
         if ($this->response['data'] > 0 && $user != null) {
            app('App\Http\Controllers\EmailController')->invitation($user, $data);
         }
         return $this->response();
      } else {
         $this->response['data'] = null;
         $this->response['error'] = $exist;
         return $this->response();
      }
   }

   public function checkIfExist($email, $owner)
   {
      $account = Account::where('email', '=', $email)->get();
      if (sizeof($account) == 0) {
         return 'Email does not exist';
      } else {
         $invites = MyCircle::where('account', '=', $account[0]->id)->where('account_id', '=', $owner)->where('status', '!=', 'declined')->get();
         return (sizeof($invites) > 0) ? 'Email Address was already invited.' : false;
      }
   }

   public function getDetails($id)
   {
      $result = MyCircle::where('id', '=', $id)->get();
      return (sizeof($result) > 0) ? $result[0] : null;
   }

   public function generateCode()
   {
      $code = "cir_" . substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 60);
      $codeExist = MyCircle::where('id', '=', $code)->get();
      if (sizeof($codeExist) > 0) {
         $this->generateCode();
      } else {
         return $code;
      }
   }

   public function confirmReferral($code)
   {
      $result = MyCircle::where('code', '=', $code)->update(array(
         'status' => 'confirmed',
         'updated_at' => Carbon::now()
      ));

      $referrral = MyCircle::where('code', '=', $code)->get();

      if (sizeof($referrral) > 0) {
         app('App\Http\Controllers\EmailController')->notifyReferrer($referrral[0]['account_id']);
      }
   }

   public function retrieve(Request $request)
   {
      $data = $request->all();
      $con = $data['condition'];
      if (isset($data['limit'])) {
         $this->response['data'] = MyCircle::where(function ($query) use ($con) {
            $query->where($con[0]['column'], $con[0]['clause'], $con[0]['value'])
               ->orWhere($con[1]['column'], $con[0]['clause'], $con[1]['value']);
         })->where($con[2]['column'], $con[2]['clause'], $con[2]['value'])->offset($data['offset'])->limit($data['limit'])->get();
      } else {
         $this->response['data'] = MyCircle::where(function ($query) use ($con) {
            $query->where($con[0]['column'], $con[0]['clause'], $con[0]['value'])
               ->orWhere($con[1]['column'], $con[0]['clause'], $con[1]['value']);
         })->where($con[2]['column'], $con[2]['clause'], $con[2]['value'])->get();
      }
      $i = 0;
      $result = $this->response['data'];
      foreach ($result as $key) {
         $count=0;
         $value = $data['condition'][0]['value'];
         $result[$i]['status'] = $key['status'];
         $result[$i]['account_id'] = $key['account_id'];
         $accountId = $value == $result[$i]['account_id'] ? $key['account'] : $key['account_id'];
         $othersConnection = $this->retrieveOtherConnection($accountId, $data['condition'][0]['value']);
         $a = 0;
         foreach ($othersConnection as $others) {
            if (($others['account'] == $accountId || $others['account_id'] == $accountId)) {
               $count++;
               $result[$i]['similar_connections'] = $count;
               $a++;
            } else {
               $result[$i]['similar_connections'] = 0;
            }
         }
         $result[$i]['account'] = $this->retrieveFullAccountDetails($accountId);
         unset($result[$i]['account']['billing']);
         $result[$i]['rating'] = app($this->ratingClass)->getRatingByPayload('profile', $accountId);
         $i++;
         $this->response['data'] = $result;
      }
      return $this->response;
   }

   public function retrieveOtherAccount(Request $request)
   {
      $data = $request->all();
      $i = 0;
      $result = Account::where('id', '!=', $data['account_id'])->where('deleted_at', '=', null)->limit($data['limit'])->offset($data['offset'])->get();
      foreach ($result as $keyAcc) {
         $result[$i]['is_added'] = false;
         $temp = MyCircle::where('account', '=', $keyAcc['id'])->orWhere('account_id', '=', $keyAcc['id'])->where('deleted_at', '=', null)->get();
         if (sizeof($temp) > 0) {
            $mycircle = MyCircle::where('account', '=', $data['account_id'])->orWhere('account_id', '=', $data['account_id'])->where('deleted_at', '=', null)->get();
            $j = 0;
            foreach ($mycircle as $value) {
               $count = 0;
               if ($value['account'] == $data['account_id'] || $value['account_id'] == $data['account_id']) {
                  if ($result[$i]['id'] == $value['account'] || $result[$i]['id'] == $value['account_id']) {
                     $othersId = $data['account_id'] === $value['account'] ? $value['account_id'] : $value['account'];
                     $othersConnection = $this->retrieveOtherConnection($othersId, $data['account_id']);
                     $a = 0;
                     $result[$i]['similar_connections'] = 0;
                     foreach ($othersConnection as $others) {
                        if (($others['account'] == $value['account'] || $others['account_id'] == $value['account_id']) || ($others['account'] == $value['account_id'] || $others['account_id'] == $value['account'])) {
                           $count++;
                           $result[$i]['similar_connections'] = $count;
                           $a++;
                        } else {
                           $result[$i]['similar_connections'] = 0;
                        }
                     }
                     $result[$i]['is_added'] = true;
                  }
               } else {
                  $result[$i]['is_added'] = false;
               }
               $j++;
            }
         }
         $i++;
      }
      if (sizeof($result) > 0) {
         $j = 0;
         foreach ($result as $key) {
            $result[$j]['status'] = $key['status'];
            $result[$j]['account_id'] =  $result[$j]['id'];
            $result[$j]['account'] = $this->retrieveFullAccountDetails($result[$j]['id']);
            unset($result[$j]['account']['billing']);
            $result[$j]['rating'] = app($this->ratingClass)->getRatingByPayload('profile',  $result[$j]['id']);
            $j++;
         }
         $this->response['data'] = $result;
      }
      return $this->response();
   }

   public function retrieveAccount($account, $accountId)
   {
      // dd($account, $accountId);
      $result = Account::where('id', '!=', $account)->where('id', '!=', $accountId)->get();

      return sizeof($result) > 0 ? $result : [];
   }



   public function retrieveName($accountId)
   {
      $result = app('Increment\Account\Http\AccountController')->retrieveById($accountId);
      if (sizeof($result) > 0) {
         $result[0]['information'] = app('Increment\Account\Http\AccountInformationController')->getAccountInformation($accountId);
         if ($result[0]['information'] != null && $result[0]['information']['first_name'] != null && $result[0]['information']['last_name'] != null) {
            $account = array(
               'names' => $result[0]['information']['first_name'] . ' ' . $result[0]['information']['last_name'],
               'email' => $result[0]['email']
            );
            return $account;
         }
         $account = array(
            'names' => $result[0]['username'],
            'email' => $result[0]['email']
         );
         return $account;
      } else {
         return null;
      }
   }

   public function retrieveOtherConnection($accountId, $ownerId)
   {
      $result = MyCircle::where(function ($query) use ($accountId) {
         $query->where('account_id', '=', $accountId)
            ->orWhere('account', '=', $accountId);
      })->where('status', '=', 'accepted')->get();
      $i=0;
      $res = array();
      foreach ($result as $key) {
         if($key['account'] !== $ownerId && $key['account_id'] !== $ownerId){
            array_push($res, $key);
         }
         $i++;
      }

      return $res;
   }
}
