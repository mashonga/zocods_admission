<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create()
    {
        $programs = Program::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('applications.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program' => 'required|string',
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'postal_address' => 'nullable|string',
            'district' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'highest_qualification' => 'nullable|string',
            'other_qualifications' => 'nullable|string',
            'previous_school' => 'nullable|string|max:255',
            'exam_board' => 'nullable|string|max:255',
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'id_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'occupation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'sponsor' => 'nullable|string|max:255',
            'sponsor_phone' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'agreed' => 'required|boolean',
        ]);

        // Store the application (uncomment when Application model exists)
        // Application::create($validated);

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }
}
