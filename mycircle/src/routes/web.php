<?php
// MyCircles Controller
$route = env('PACKAGE_ROUTE', '').'/my_circles/';
$controller = 'Increment\Common\MyCircle\Http\MyCircleController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'validate', $controller."retrieveByValidation");
Route::post($route.'delete', $controller."delete");
Route::post($route.'update', $controller."update");