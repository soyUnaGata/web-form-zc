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

    Route::get('/test', function (Request $request, ZohoCrmApi $zohoCrmApi) {
        $resp = $zohoCrmApi->test();
        return $resp;
    });

    Route::get('/test2', function (Request $request, ZohoCrmApi $zohoCrmApi) {
        $resp = $zohoCrmApi->UpsertDeal(null);
        return $resp;
    });
});



