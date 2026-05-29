<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Models\IntakeProgram;
use App\Models\Program;
use Illuminate\Http\Request;

class IntakeProgramController extends Controller
{
    public function index()
    {
        $intakes = Intake::orderBy('sort_order')->get();
        $programs = Program::where('is_active', true)->orderBy('sort_order')->get();

        $intakePrograms = IntakeProgram::with(['intake', 'program'])
            ->latest()
            ->get();

        return view('admin.intake-programs.index', compact('intakes', 'programs', 'intakePrograms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'intake_id' => 'required|exists:intakes,id',
            'program_id' => 'required|exists:programs,id',
            'required_subject_count' => 'nullable|integer|min:1|max:20',
            'is_active' => 'required|in:0,1',
        ]);

        IntakeProgram::updateOrCreate(
            [
                'intake_id' => $data['intake_id'],
                'program_id' => $data['program_id'],
            ],
            [
                'required_subject_count' => $data['required_subject_count'],
                'is_active' => (bool) $data['is_active'],
            ]
        );

        return back()->with('success', 'Program assigned to intake successfully.');
    }

    public function destroy(IntakeProgram $intakeProgram)
    {
        $intakeProgram->delete();

        return back()->with('success', 'Program removed from intake.');
    }
}