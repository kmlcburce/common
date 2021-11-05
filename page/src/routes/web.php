<?php

// Scope Location
$route = env('PACKAGE_ROUTE', '').'/pages/';
$controller = 'Increment\Common\Page\Http\PageController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");


$route = env('PACKAGE_ROUTE', '').'/page_roles/';
$controller = 'Increment\Common\Page\Http\PageRoleController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");


$route = env('PACKAGE_ROUTE', '').'/page_accounts/';
$controller = 'Increment\Common\Page\Http\PageAccountController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");