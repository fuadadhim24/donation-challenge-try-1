<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        return view('donor.dashboard');
    }
}
