<?php

// Scope Location
$route = env('PACKAGE_ROUTE', '').'/location_scopes/';
$controller = 'Increment\Common\Scope\Http\LocationScopeController@';
Route::post($route.'create', $controller."create");
Route::post($route.'create_scope', $controller."createScope");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::get($route.'test', $controller."test");
