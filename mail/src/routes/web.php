<?php
$route = env('PACKAGE_ROUTE', '').'/aws-sns/';
$controller = 'Increment\Common\Mail\Http\MailController@';
Route::any($route.'bounces', $controller.'onBounce');
Route::any($route.'complaints', $controller.'onComplaint');
Route::any($route.'deliveries', $controller.'onDelivery');