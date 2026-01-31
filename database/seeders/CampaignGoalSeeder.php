<?php

namespace Database\Seeders;

use App\Models\CampaignGoal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goals = [
            'Raise Awareness',
            'Drive Clicks or Visits',
            'Drive App Installs or Leads',
        ];

        foreach ($goals as $goal) {
            CampaignGoal::create([
                'name' => $goal,
            ]);
        }
    }
}

