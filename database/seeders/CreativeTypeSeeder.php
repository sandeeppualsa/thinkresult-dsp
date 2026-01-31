<?php

namespace Database\Seeders;

use App\Models\CreativeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreativeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Display',
            'Video',
            'Audio',
            'YouTube',
            'Native',
        ];

        foreach ($types as $type) {
            CreativeType::create([
                'name' => $type,
            ]);
        }
    }
}

