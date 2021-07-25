<?php
Route::any('/ses-bounce-payhiram', [Increment\Common\Mail\Http\MailController::class, 'handle']);
Route::any('/ses-complaints-payhiram', [Increment\Common\Mail\Http\MailController::class, 'handle']);
Route::any('/ses-deliveries-payhiram', [Increment\Common\Mail\Http\MailController::class, 'handle']);