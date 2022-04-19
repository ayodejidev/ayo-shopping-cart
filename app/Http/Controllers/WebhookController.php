<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index(Request $request)
    {
        logger((array)$request->all());
        \Log::info("webhook: ", (array)$request->all());
    }
}
