<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Grain'],
            ['name' => 'Fruits'],
            ['name' => 'Vegetables'],
            ['name' => 'Oil Seed'],
            ['name' => 'Pulse']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
