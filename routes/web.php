<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use \App\Http\Controllers\FormController;
use App\Http\Controllers\DealController;
use \App\Services\ZohoCrmApi;
use Illuminate\Support\Facades\URL;

Route::get('/{any}', FormController::class)->where('any', '^(?!api).*$');

Route::prefix('api')->group(function() {
    Route::post('/deals', DealController::class);
    Route::get('/oauthredirect', function (Request $request, ZohoCrmApi $zohoCrmApi) {
        $code = $request->query('code');
        $zohoCrmApi->AccessToken($code);
        return redirect('/');
    });
});



