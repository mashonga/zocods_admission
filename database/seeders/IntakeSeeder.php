<?php

namespace Database\Seeders;

use App\Models\Intake;
use Illuminate\Database\Seeder;

class IntakeSeeder extends Seeder
{
    public function run(): void
    {
        $intakes = [
            [
                'name' => 'January - June',
                'slug' => 'january-june',
                'start_month' => 'January',
                'end_month' => 'June',
                'study_mode' => 'Online',
                'sort_order' => 1,
            ],
            [
                'name' => 'March - September',
                'slug' => 'march-september',
                'start_month' => 'March',
                'end_month' => 'September',
                'study_mode' => 'Online',
                'sort_order' => 2,
            ],
            [
                'name' => 'July - December',
                'slug' => 'july-december',
                'start_month' => 'July',
                'end_month' => 'December',
                'study_mode' => 'Online',
                'sort_order' => 3,
            ],
            [
                'name' => 'October - March',
                'slug' => 'october-march',
                'start_month' => 'October',
                'end_month' => 'March',
                'study_mode' => 'Online',
                'sort_order' => 4,
            ],
        ];

        foreach ($intakes as $intake) {
            Intake::updateOrCreate(
                ['slug' => $intake['slug']],
                [
                    'name' => $intake['name'],
                    'start_month' => $intake['start_month'],
                    'end_month' => $intake['end_month'],
                    'study_mode' => $intake['study_mode'],
                    'is_active' => true,
                    'sort_order' => $intake['sort_order'],
                ]
            );
        }
    }
}