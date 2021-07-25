<?php

namespace Increment\Common\Mail\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use RenokiCo\AwsWebhooks\Http\Controllers\SesWebhook;
class MailController extends SesWebhook
{
  protected function onBounce(array $message, array $originalMessage, Request $request){
    $email = null;

    if($email){
      app('Increment\Account\Http\AccountController')->updateByParamsByEmail($email, array((
        'status' => 'INVALID_EMAIL',
        'updated_at' => Carbon::now()
      )));

      // unsubscribe
    }
  }
  
  protected function onComplaint(array $message, array $originalMessage, Request $request){
      //
  }

  protected function onDelivery(array $message, array $originalMessage, Request $request){
      //
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
