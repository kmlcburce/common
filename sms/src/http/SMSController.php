<?php

namespace Increment\Common\Sms\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use Twilio\Rest\Client;
use Twilio\TwiML\MessagingResponse;
use Illuminate\Support\Facades\Log;
use Exception;
class SMSController extends APIController
{
  public function sendFromRequest(Request $request){
    $data = $request->all();
    $accountID = env("TWILIO_SID");
    $authToken = env("TWILIO_AUTH_TOKEN");
    $sender = env("TWILIO_NUMBER");
    $callBackUrl = env('TWILIO_CALLBACK_URL');
    $client = new Client($accountID, $this->authToken);
    return $client->messages->create($data['receiver'], [
      'from' => $data['sender'],
      'body' => $data['messages'],
      'statusCallback' => env('TWILIO_CALLBACK_URL')
    ]);
  }

  public function sendDirect($data){
    $accountID = env("TWILIO_SID");
    $authToken = env("TWILIO_AUTH_TOKEN");
    $sender = env("TWILIO_NUMBER");
    $callBackUrl = env('TWILIO_CALLBACK_URL');
    $client = new Client($accountID, $this->authToken);
    return $client->messages->create($data['receiver'], [
      'from' => $data['sender'],
      'body' => $data['messages'],
      'statusCallback' => env('TWILIO_CALLBACK_URL')
    ]);
  }
}
