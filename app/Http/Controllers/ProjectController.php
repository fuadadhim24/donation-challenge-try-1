<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->take(6)
            ->orderBy('created_at', 'desc')->with('images')
            ->get();

        return Inertia::render('welcome', [
            'projects' => $projects
        ]);
    }

    public function listProject()
    {
        $projects = Project::latest()->take(6)
            ->orderBy('created_at', 'desc')->with('images')
            ->get();

        return Inertia::render('project/donations', [
            'projects' => $projects
        ]);
    }
    public function donate(Project $project)
    {
        $project->load('images');
        $relatedProject = Project::where('id', '!=', $project->id)
            ->latest()
            ->take(6)
            ->orderBy('created_at', 'desc')
            ->with('images')
            ->get();
        return Inertia::render('project/detail', [
            'project' => $project,
            'relatedProjects' => $relatedProject,
        ]);
    }
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        if ($project->requester_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        foreach ($project->images as $img) {
            $path = public_path($img->url);

            if (File::exists($path)) {
                File::delete($path);
            }

            $img->delete();
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted']);
    }
    public function updateStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $project->status = $request->status;
        $project->save();

        return response()->json(['message' => 'Status updated']);
    }
}
