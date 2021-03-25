<?php

// Plan
$route = env('PACKAGE_ROUTE', '').'/invitations/';
$controller = 'Increment\Common\Invitation\Http\InvitationController@';
Route::post($route.'create', $controller."create");
Route::post($route.'create-width-validation', $controller."createWithValidation");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::post($route.'apply', $controller."apply");
Route::get($route.'test', $controller."test");
