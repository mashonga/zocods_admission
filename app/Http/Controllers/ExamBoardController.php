<?php

namespace App\Http\Controllers;

use App\Models\ExamBoard;
use Illuminate\Http\Request;

class ExamBoardController extends Controller
{
    public function index()
    {
        $examBoards = ExamBoard::orderBy('name')->get();

        return view('admin.exam-boards.index', compact('examBoards'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:exam_boards,name',
            'code' => 'required|string|max:50|unique:exam_boards,code',
        ]);

        ExamBoard::create([
            'name' => strtoupper(trim($data['name'])),
            'code' => strtoupper(trim($data['code'])),
        ]);

        return back()->with('success', 'Exam board added successfully.');
    }

    public function destroy(ExamBoard $examBoard)
    {
        $examBoard->delete();

        return back()->with('success', 'Exam board deleted.');
    }
}