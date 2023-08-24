<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterSuccessController extends Controller
{
    public function index()
    {
        return view('pages.register_success');
    }
}