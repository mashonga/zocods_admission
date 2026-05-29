<?php

namespace App\Http\Controllers;

use App\Models\BoardFee;
use App\Models\ExamBoard;
use Illuminate\Http\Request;

class BoardFeeController extends Controller
{
    public function index()
    {
        $boardFees = BoardFee::with('examBoard')
            ->orderByDesc('id')
            ->get();

        $examBoards = ExamBoard::orderBy('name')->get();

        return view('admin.board-fees.index', compact('boardFees', 'examBoards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_board_id' => 'required|exists:exam_boards,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|in:MWK,USD',
        ]);

        BoardFee::updateOrCreate(
            [
                'exam_board_id' => $data['exam_board_id'],
                'currency' => $data['currency'], // 🔥 FIX
            ],
            [
                'fee_name' => 'Board Fee',
                'amount' => $data['amount'],
            ]
        );

        return back()->with('success', 'Board fee saved successfully.');
    }

    public function destroy(BoardFee $boardFee)
    {
        $boardFee->delete();

        return back()->with('success', 'Board fee deleted.');
    }
}