<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class RequesterController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalProjects = Project::where('requester_id', $userId)->count();
        $activeProjects = Project::where('requester_id', $userId)->where('status', 'approved')->count();
        $pendingProjects = Project::where('requester_id', $userId)->where('status', 'need_review')->count();
        $rejectedProjects = Project::where('requester_id', $userId)->where('status', 'rejected')->count();
        $finishedProjects = Project::where('requester_id', $userId)->where('status', 'completed')->count();
        $totalCollected = Project::where('requester_id', $userId)->sum('collection_amount');

        $projects = Project::with('images')
            ->where('requester_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('requester/dashboard', compact(
            'projects',
            'totalProjects',
            'activeProjects',
            'pendingProjects',
            'rejectedProjects',
            'finishedProjects',
            'totalCollected'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1000',
            'currency' => 'required|string|size:3',
            'status' => 'required|in:need_review,approved,completed,rejected',
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'target_amount' => $validated['target_amount'],
            'currency' => $validated['currency'],
            'status' => $validated['status'],
            'requester_id' => Auth::id(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('requester/projects');
                $file->move($destinationPath, $filename);

                $project->images()->create([
                    'url' => "requester/projects/{$filename}",
                ]);
            }
        }

        return response()->json([
            'message' => 'Project created successfully',
            'project' => $project->load('images'),
        ]);
    }
}