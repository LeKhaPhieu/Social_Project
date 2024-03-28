<?php

namespace App\Http\Controllers;

class PostController extends Controller
{
    public function homePage() {
        return view('guest.home');
    }
}
