<?php

namespace Database\Seeders;

use App\Models\KPI;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KPISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kpis = [
            'CPM',
            'CPC',
            'CPV (Cost per Visit)',
            'Cost Per View',
            'CPCV (Cost Per Completed Views)',
        ];

        foreach ($kpis as $kpi) {
            KPI::create([
                'name' => $kpi,
            ]);
        }
    }
}

