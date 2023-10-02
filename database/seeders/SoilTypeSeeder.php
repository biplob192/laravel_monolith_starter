<?php

namespace Database\Seeders;

use App\Models\SoilType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoilTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'Sandy Soil',
            ],
            [
                'name' => 'Loamy Soil',
            ],
            [
                'name' => 'Clay Soil',
            ],
            [
                'name' => 'Silty Soil',
            ],
            [
                'name' => 'Sandy Loam Soil',
            ],
            [
                'name' => 'Loamy Sand Soil',
            ],
            [
                'name' => 'Sandy Clay Loam Soil',
            ],
            [
                'name' => 'Silty Clay Loam Soil',
            ],
            [
                'name' => 'Clay Loam Soil',
            ],
        ];

        foreach ($types as $type) {
            SoilType::create($type);
        }
    }
}
