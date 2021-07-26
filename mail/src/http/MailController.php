<?php

namespace Increment\Common\Mail\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
class MailController extends APIController
{
  protected function onBounce(Request $request){
    $email = null;

    if($email){
      app('Increment\Account\Http\AccountController')->updateByParamsByEmail($email, array((
        'status' => 'INVALID_EMAIL',
        'updated_at' => Carbon::now()
      )));

      // unsubscribe
    }

    return array(
      "data" => json_encode($request->all())
    );
  }
  
  protected function onComplaint(Request $request){
    return array(
      "data" => json_encode($request->all())
    );
  }

  protected function onDelivery(Request $request){
    return array(
      "data" => json_encode($request->all())
    );
  }

  protected function onSend(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onReject(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onOpen(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onClick(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onRenderingFailure(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onDeliveryDelay(array $message, array $originalMessage, Request $request){
      //
  }
}
