<?php
$route = env('PACKAGE_ROUTE', '').'/mails/';
$controller = 'Increment\Common\Mail\Http\MailController@';
Route::post($route.'bounce', $controller."bounceHandler");
Route::post($route.'complaints', $controller."complaintHandler");
Route::post($route.'delivered', $controller."deliveredHandler");