<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \App\Http\Controllers\FormController;
use App\Http\Controllers\DealController;

Route::get('/{any}', FormController::class)->where('any', '^(?!api).*$');

Route::prefix('api')->group(function() {
    Route::post('/deals', DealController::class);

    //Route::post('/deals', DealController::class);

});
