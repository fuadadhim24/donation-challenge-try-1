<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RequesterController extends Controller
{
    public function index()
    {
        $projects = Project::where('requester_id', Auth::id())->get();
        $totalProjects     = $projects->count();
        $activeProjects    = $projects->where('status', 'approved')->count();
        $pendingProjects   = $projects->where('status', 'need_review')->count();
        $rejectedProjects  = $projects->where('status', 'rejected')->count();
        $finishedProjects  = $projects->where('status', 'completed')->count();
        $totalCollected = $projects->sum('collection_amount');

        return Inertia::render(
            'requester/dashboard',
            [
                'projects'        => $projects,
                'totalProjects'   => $totalProjects,
                'activeProjects'  => $activeProjects,
                'pendingProjects' => $pendingProjects,
                'rejectedProjects' => $rejectedProjects,
                'finishedProjects' => $finishedProjects,
                'totalCollected'  => $totalCollected,
            ]
        );
    }
}
