<?php
$route = env('PACKAGE_ROUTE', '').'/system_notifications/';
$controller = 'Increment\Common\System\Http\SystemNotificationController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");