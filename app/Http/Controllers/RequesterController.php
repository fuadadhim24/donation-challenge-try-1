<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RequesterController extends Controller
{
    public function index()
    {
        return Inertia::render('requester/dashboard');
    }
}
