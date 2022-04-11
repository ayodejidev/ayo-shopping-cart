<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function contactUs()
    {
        return view('contact');
    }
}
