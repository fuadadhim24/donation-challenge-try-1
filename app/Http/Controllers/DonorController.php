<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DonorController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        $donations = Donation::with('project')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $totalDonation = $donations->sum('amount');
        $totalProjects = $donations->pluck('project_id')->unique()->count();

        return Inertia::render('donor/dashboard', [
            'auth' => [
                'user' => $user
            ],
            'donations' => $donations,
            'summary' => [
                'total_donation' => $totalDonation,
                'total_projects' => $totalProjects
            ]
        ]);
    }
}
