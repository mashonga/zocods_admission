<?php

namespace App\Http\Controllers;

use App\Models\Intake;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IntakeController extends Controller
{
    public function index()
    {
        $intakes = Intake::with(['intakePrograms.program'])
            ->orderBy('sort_order')
            ->get();

        $programs = Program::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.intakes.index', compact('intakes', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:intakes,name',
            'start_month' => 'required|string|max:30',
            'end_month' => 'required|string|max:30',
            'study_mode' => 'required|string|max:50',
            'is_active' => 'required|in:0,1',
            'selected_programs' => 'required|array|min:1',
            'selected_programs.*' => 'integer|exists:programs,id',
            'program_settings' => 'nullable|array',
        ]);

        DB::transaction(function () use ($validated) {
            $intake = Intake::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'start_month' => $validated['start_month'],
                'end_month' => $validated['end_month'],
                'study_mode' => $validated['study_mode'],
                'is_active' => (bool) $validated['is_active'],
                'sort_order' => Intake::count() + 1,
            ]);

            foreach ($validated['selected_programs'] as $programId) {
                $settings = $validated['program_settings'][$programId] ?? [];

                $requiredSubjectCount = $settings['required_subject_count'] ?? null;
                $tuitionFeeNotes = $settings['tuition_fee_notes'] ?? null;
                $programIsActive = isset($settings['is_active']) ? (bool) $settings['is_active'] : true;

                $intake->intakePrograms()->create([
                    'program_id' => $programId,
                    'required_subject_count' => $requiredSubjectCount !== null && $requiredSubjectCount !== ''
                        ? (int) $requiredSubjectCount
                        : null,
                    'tuition_fee_notes' => $tuitionFeeNotes ?: null,
                    'is_active' => $programIsActive,
                ]);
            }
        });

        return back()->with('success', 'Intake created successfully.');
    }

    public function destroy(Intake $intake)
    {
        $intake->delete();

        return back()->with('success', 'Intake deleted.');
    }
}