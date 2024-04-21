<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ZohoCrmApi;
use Illuminate\Support\Facades\Cache;


class FormController extends Controller
{
    /**
     * Handle the incoming request.
     */
    private ZohoCrmApi $zohoCrmApi;

    public function __construct(ZohoCrmApi $zohoCrmApi)
    {
        $this->zohoCrmApi = $zohoCrmApi;
    }

    public function __invoke()
    {
        if (Cache::get('credentials') === null){
            return redirect($this->zohoCrmApi->Authorization());
        }
        return view('form');
    }
}
