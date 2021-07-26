<?php
$route = env('PACKAGE_ROUTE', '').'/aws-sns/';
$controller = 'Increment\Common\Mail\Http\MailController@';
Route::any('bounces', $controller.'onBounce');
Route::any('complaints', $controller.'onComplaint');
Route::any('deliveries', $controller.'onDelivery');