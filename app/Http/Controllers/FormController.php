<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class FormController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('form');
    }
}
