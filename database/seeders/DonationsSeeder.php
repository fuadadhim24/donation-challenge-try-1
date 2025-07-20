<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;

class DonationsSeeder extends Seeder
{
    public function run(): void
    {
        $donors = User::whereHas('role', fn($q) => $q->where('role', 'donor'))->get();
        $projects = Project::all();

        if ($donors->isEmpty() || $projects->isEmpty()) {
            $this->command->warn('No donors or projects found. Run ProjectsSeeder and create donor users first.');
            return;
        }

        foreach ($projects as $project) {
            foreach ($donors->random(min(3, $donors->count())) as $donor) {
                Donation::create([
                    'project_id' => $project->id,
                    'user_id' => $donor->id,
                    'message' => fake()->sentence(6),
                    'amount' => rand(50_000, 2_000_000),
                    'currency' => 'IDR',
                ]);
            }
        }
    }
}
