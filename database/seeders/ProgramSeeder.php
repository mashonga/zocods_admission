<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['name' => 'Bachelor of Science in Computer Science', 'duration' => '4 years'],
            ['name' => 'Bachelor of Business Administration', 'duration' => '3 years'],
            ['name' => 'Master of Science in Data Science', 'duration' => '2 years'],
            ['name' => 'Bachelor of Arts in Graphic Design', 'duration' => '3 years'],
            ['name' => 'Master of Business Administration (MBA)', 'duration' => '2 years'],
            ['name' => 'Bachelor of Science in Nursing', 'duration' => '4 years'],
            ['name' => 'Diploma in Information Technology', 'duration' => '1.5 years'],
            ['name' => 'Bachelor of Laws (LLB)', 'duration' => '4 years'],
            ['name' => 'Master of Public Health', 'duration' => '2 years'],
            ['name' => 'Bachelor of Education', 'duration' => '3 years'],
            ['name' => 'Bachelor of Engineering in Civil Engineering', 'duration' => '4 years'],
            ['name' => 'Bachelor of Pharmacy', 'duration' => '4 years'],
            ['name' => 'Bachelor of Science in Accounting', 'duration' => '3 years'],
            ['name' => 'Bachelor of Arts in Psychology', 'duration' => '3 years'],
            ['name' => 'Master of Information Technology', 'duration' => '2 years'],
            ['name' => 'Diploma in Business Management', 'duration' => '1.5 years'],
            ['name' => 'Bachelor of Science in Biotechnology', 'duration' => '4 years'],
            ['name' => 'Bachelor of Architecture', 'duration' => '5 years'],
            ['name' => 'Bachelor of Social Work', 'duration' => '3 years'],
            ['name' => 'Master of Education', 'duration' => '2 years'],
        ];

        foreach ($programs as $program) {
            $slug = Str::slug($program['name']);
            
            // Check if program already exists
            $exists = DB::table('programs')->where('slug', $slug)->exists();
            
            if (!$exists) {
                DB::table('programs')->insert([
                    'id' => Str::uuid(),
                    'name' => $program['name'],
                    'slug' => $slug,
                    'duration' => $program['duration'],
                    'is_active' => true,
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Programs seeded successfully!');
    }
}
