<?php

namespace Database\Seeders;

use App\Models\BoardFee;
use App\Models\ExamBoard;
use Illuminate\Database\Seeder;

class BoardFeeSeeder extends Seeder
{
    public function run(): void
    {
        $fees = [
            ['board_code' => 'ABMA', 'fee_name' => 'Examination Fee', 'amount' => 0.00, 'currency' => 'MWK'],
            ['board_code' => 'ABP', 'fee_name' => 'Examination Fee', 'amount' => 0.00, 'currency' => 'MWK'],
            ['board_code' => 'ICAM', 'fee_name' => 'Examination Fee', 'amount' => 0.00, 'currency' => 'MWK'],
        ];

        foreach ($fees as $fee) {
            $board = ExamBoard::where('code', $fee['board_code'])->first();

            if (!$board) {
                continue;
            }

            BoardFee::updateOrCreate(
                [
                    'exam_board_id' => $board->id,
                    'fee_name' => $fee['fee_name'],
                ],
                [
                    'amount' => $fee['amount'],
                    'currency' => $fee['currency'],
                ]
            );
        }
    }
}