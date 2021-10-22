<?php
$route = env('PACKAGE_ROUTE', '').'/aws-sns/';
$controller = 'Increment\Common\Mail\Http\MailController@';
Route::any($route.'bounces', $controller.'onBounce');
Route::any($route.'complaints', $controller.'onComplaint');
Route::any($route.'deliveries', $controller.'onDelivery');


// http://7d4068667a81.ngrok.io/project123/api/public/increment/v1/aws-sns/bounces




// http://007c543715af.ngrok.io/project123/api/public/increment/v1/aws-sns/deliveries