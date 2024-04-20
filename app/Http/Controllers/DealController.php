<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deal\DealRequest;


class DealController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(DealRequest $request)
    {
        $data = $request->validated();
        return $data;
    }
}
