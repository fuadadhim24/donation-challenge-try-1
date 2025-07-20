<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectsImage;

class ProjectImagesSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();

        if ($projects->isEmpty()) {
            $this->command->warn('No projects found. Run ProjectsSeeder first.');
            return;
        }

        foreach ($projects as $project) {
            ProjectImage::create([
                'project_id' => $project->id,
                'url' => 'https://source.unsplash.com/800x600/?disaster,relief,' . rand(1, 100),
            ]);

            ProjectImage::create([
                'project_id' => $project->id,
                'url' => 'https://source.unsplash.com/800x600/?volunteer,help,' . rand(1, 100),
            ]);
        }
    }
}
