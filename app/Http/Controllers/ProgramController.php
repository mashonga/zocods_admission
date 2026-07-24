<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::orderBy('sort_order')->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:programs,name',
            'duration' => 'nullable|string|max:100',
            'fees' => 'nullable|string|max:255',
            'introduction' => 'nullable|string',
            'entry_requirements' => 'nullable|string',
            'mode_of_delivery' => 'nullable|string',
            'duration_details' => 'nullable|string',
            'module_summary' => 'nullable|string',
            'qualification_levels' => 'nullable|string',
            'assessment_details' => 'nullable|string',
            'grading_system' => 'nullable|string',
            'progression_details' => 'nullable|string',
            'field_practicals' => 'nullable|string',
        ]);

        Program::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'duration' => $data['duration'],
            'fees' => $data['fees'] ?? null,
            'introduction' => $data['introduction'] ?? null,
            'entry_requirements' => $data['entry_requirements'] ?? null,
            'mode_of_delivery' => $data['mode_of_delivery'] ?? null,
            'duration_details' => $data['duration_details'] ?? null,
            'module_summary' => $data['module_summary'] ?? null,
            'qualification_levels' => $data['qualification_levels'] ?? null,
            'assessment_details' => $data['assessment_details'] ?? null,
            'grading_system' => $data['grading_system'] ?? null,
            'progression_details' => $data['progression_details'] ?? null,
            'field_practicals' => $data['field_practicals'] ?? null,
            'is_active' => true,
            'sort_order' => Program::count() + 1,
        ]);

        return back()->with('success', 'Program added successfully.');
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:programs,name,' . $program->id,
            'duration' => 'nullable|string|max:100',
            'fees' => 'nullable|string|max:255',
            'introduction' => 'nullable|string',
            'entry_requirements' => 'nullable|string',
            'mode_of_delivery' => 'nullable|string',
            'duration_details' => 'nullable|string',
            'module_summary' => 'nullable|string',
            'qualification_levels' => 'nullable|string',
            'assessment_details' => 'nullable|string',
            'grading_system' => 'nullable|string',
            'progression_details' => 'nullable|string',
            'field_practicals' => 'nullable|string',
        ]);

        $program->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'duration' => $data['duration'],
            'fees' => $data['fees'] ?? null,
            'introduction' => $data['introduction'] ?? null,
            'entry_requirements' => $data['entry_requirements'] ?? null,
            'mode_of_delivery' => $data['mode_of_delivery'] ?? null,
            'duration_details' => $data['duration_details'] ?? null,
            'module_summary' => $data['module_summary'] ?? null,
            'qualification_levels' => $data['qualification_levels'] ?? null,
            'assessment_details' => $data['assessment_details'] ?? null,
            'grading_system' => $data['grading_system'] ?? null,
            'progression_details' => $data['progression_details'] ?? null,
            'field_practicals' => $data['field_practicals'] ?? null,
        ]);

        return back()->with('success', 'Program updated successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return back()->with('success', 'Program deleted.');
    }

    public function showPublic($slug)
    {
        $program = Program::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('program-details', compact('program'));
    }
}