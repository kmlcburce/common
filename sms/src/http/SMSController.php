<?php

namespace Increment\Common\Sms\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Exception;
class SMSController extends APIController
{

  public $response = null;
  public $baseUrl = 'https://api.m360.com.ph/v3/api/broadcast';
  public $baseUrlOTP = 'https://api.m360.com.ph/v3/api/pin/send';

  public function send(Request $request){
    $data = $request->all();
    $this->curl($this->baseUrl, $data);
    return response()->json(json_decode($this->response));
  }

  public function sendDirect($params){
    $this->curl($this->baseUrl, $params);
    return response()->json(json_decode($this->response));
  }

  public function otp($params){
    $this->curl($this->baseUrlOTP, $params);
    return response()->json(json_decode($this->response));
  }

  public function curl($url, $params){
    $ch = curl_init();

    $headers[] = 'Content-Type: application/json';
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));

    $this->response = curl_exec($ch);
    curl_close($ch);
  }
}
