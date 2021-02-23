<?php
$route = env('PACKAGE_ROUTE', '').'/payloads/';
$controller = 'Increment\Common\Payload\Http\PayloadController@';
Route::post($route.'create', $controller."create");
Route::post($route.'retrieve', $controller."retrieve");
Route::post($route.'update', $controller."update");
Route::post($route.'delete', $controller."delete");
Route::post($route.'get_valid_id', $controller."checkValidId");
Route::post($route.'upload_valid_id', $controller."uploadValidId");
Route::post($route.'create_faqs', $controller."createFaqs");
Route::post($route.'create_category', $controller."createCategory");
Route::post($route.'get_category', $controller."getCategory");
Route::post($route.'get_resource', $controller."getResource");
Route::post($route.'faqs', $controller."retrieveFaqs");
Route::get($route.'test', $controller."test");