<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        // ambil salah satu requester (role requester)
        $requester = User::whereHas('role', fn($q) => $q->where('role', 'requester'))->first();

        if (!$requester) {
            $this->command->warn('No requester found. Skipping ProjectsSeeder...');
            return;
        }

        $projects = [
            [
                'name' => 'Bantuan Gempa Sulawesi',
                'description' => 'Gempa 6.5 SR mengguncang Sulawesi. Ribuan keluarga kehilangan tempat tinggal.',
                'target_amount' => 500_000_000,
                'collection_amount' => 120_000_000,
                'currency' => 'IDR',
                'status' => 'approved',
                'requester_id' => $requester->id,
            ],
            [
                'name' => 'Bantuan Banjir Kalimantan',
                'description' => 'Banjir bandang merendam 2.000 rumah di Kalimantan Selatan.',
                'target_amount' => 300_000_000,
                'collection_amount' => 50_000_000,
                'currency' => 'IDR',
                'status' => 'approved',
                'requester_id' => $requester->id,
            ],
            [
                'name' => 'Logistik untuk Korban Erupsi',
                'description' => 'Gunung meletus di Jawa Timur membuat 1.500 warga mengungsi.',
                'target_amount' => 200_000_000,
                'collection_amount' => 90_000_000,
                'currency' => 'IDR',
                'status' => 'need_review',
                'requester_id' => $requester->id,
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
