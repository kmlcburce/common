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
    $sender = env("TWILIO_NUMBER");
    $callBackUrl = env('TWILIO_CALLBACK_URL');
    $client = new Client(env("TWILIO_SID"), env("TWILIO_AUTH_TOKEN"));
    return $client->messages->create($data['receiver'], [
      'from' => $sender,
      'body' => $data['messages'],
      'statusCallback' => $callBackUrl
    ]);
  }

  public function sendDirect($data){
    $sender = env("TWILIO_NUMBER");
    $callBackUrl = env('TWILIO_CALLBACK_URL');
    $client = new Client(env("TWILIO_SID"), env("TWILIO_AUTH_TOKEN"));
    return $client->messages->create($data['receiver'], [
      'from' => $sender,
      'body' => $data['messages'],
      'statusCallback' => $callBackUrl
    ]);
  }
}
