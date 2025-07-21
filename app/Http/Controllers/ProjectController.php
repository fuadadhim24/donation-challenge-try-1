<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->take(6)->get();

        return Inertia::render('welcome', [
            'projects' => $projects
        ]);
    }

    public function listProject()
    {
        $projects = Project::latest()->take(6)->get();

        return Inertia::render('project/donations', [
            'projects' => $projects
        ]);
    }
    public function donate(Project $project)
    {
        $relatedProject = Project::where('id', '!=', $project->id)->take(6)->get();
        return Inertia::render('project/detail', [
            'project' => $project,
            'relatedProjects' => $relatedProject,
        ]);
    }
}
