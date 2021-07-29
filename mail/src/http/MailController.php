<?php

namespace Increment\Common\Mail\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
class MailController extends APIController
{
  protected function onBounce(Request $request){
    $content = json_decode($request->getContent(), true);
    $message = $content && isset($content['Message']) ? json_decode($content['Message'], true) : null;

    if($message){
      $recipients = $message ? $message['bounce']['bouncedRecipients'] : null;
      if($recipients && sizeof($recipients) > 0){
        foreach ($recipients as $key => $recipient) {
          if($recipient['emailAddress']){
            app('Increment\Account\Http\AccountController')->updateByParamsByEmail($recipient['emailAddress'], array(
              'status' => 'INVALID_EMAIL',
              'updated_at' => Carbon::now()
            ));

            // unsubscribe
          }
        }
      }
    }

    return 200;
  }
  
  protected function onComplaint(Request $request){
    $content = json_decode($request->getContent(), true);
    return array(
      "data" => $content
    );
  }

  protected function onDelivery(Request $request){
    $content = json_decode($request->getContent(), true);
    return 200;
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
