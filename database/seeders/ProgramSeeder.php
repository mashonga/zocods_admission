<?php

namespace Database\Seeders;

use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['name' => 'Public Health', 'duration' => null, 'sort_order' => 1],
            ['name' => 'Nutrition and Food Security', 'duration' => null, 'sort_order' => 2],
            ['name' => 'Professional Diploma in Education', 'duration' => null, 'sort_order' => 3],
            ['name' => 'Community Development', 'duration' => null, 'sort_order' => 4],
            ['name' => 'Social Work', 'duration' => null, 'sort_order' => 5],
            ['name' => 'Business Administration', 'duration' => null, 'sort_order' => 6],
            ['name' => 'Human Resource Management', 'duration' => null, 'sort_order' => 7],
            ['name' => 'Hotel and Hospitality Management', 'duration' => null, 'sort_order' => 8],
            ['name' => 'ICT', 'duration' => null, 'sort_order' => 9],
            ['name' => 'Environmental Science', 'duration' => null, 'sort_order' => 10],
            ['name' => 'Financial Accounting', 'duration' => null, 'sort_order' => 11],
        ];

        foreach ($programs as $program) {
            Program::updateOrCreate(
                ['slug' => Str::slug($program['name'])],
                [
                    'name' => $program['name'],
                    'duration' => $program['duration'],
                    'is_active' => true,
                    'sort_order' => $program['sort_order'],
                ]
            );
        }
    }
}