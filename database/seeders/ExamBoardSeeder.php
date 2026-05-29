<?php

namespace Database\Seeders;

use App\Models\ExamBoard;
use Illuminate\Database\Seeder;

class ExamBoardSeeder extends Seeder
{
    public function run(): void
    {
        $boards = [
            ['name' => 'ABMA', 'code' => 'ABMA'],
            ['name' => 'ABP', 'code' => 'ABP'],
            ['name' => 'ICAM', 'code' => 'ICAM'],
        ];

        foreach ($boards as $board) {
            ExamBoard::updateOrCreate(
                ['code' => $board['code']],
                [
                    'name' => $board['name'],
                ]
            );
        }
    }
}