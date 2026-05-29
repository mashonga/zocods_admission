<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationStatusUpdated;
use App\Models\Application;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function create()
    {
        $programs = Program::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('apply', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|max:50',
            'marital_status' => 'required|string|max:50',
            'date_of_birth' => 'required|date',
            'nationality' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'postal_address' => 'required|string',
            'program' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'employer' => 'nullable|string|max:255',
            'sponsor' => 'required|string|max:255',
            'sponsor_phone' => 'required|string|max:50',
            'exam_board' => 'required|string|max:255',
            'highest_qualification' => 'required|string|max:255',
            'other_qualifications' => 'required|string',
            'previous_school' => 'required|string|max:255',
            'certificate_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'id_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'message' => 'nullable|string',
            'agreed' => 'accepted',
        ]);

        if ($request->hasFile('certificate_file')) {
            $validated['certificate_file'] = $request->file('certificate_file')->store('applications/certificates', 'public');
        }

        if ($request->hasFile('id_file')) {
            $validated['id_file'] = $request->file('id_file')->store('applications/ids', 'public');
        }

        Application::create($validated);

        return redirect('/apply')->with('success', 'Your application has been submitted successfully.');
    }

    public function index(Request $request)
    {
        $query = Application::query();

        if ($request->program) {
            $query->where('program', $request->program);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->get();

        $programs = Application::select('program')->distinct()->orderBy('program')->pluck('program');

        $stats = [
            'total' => Application::count(),
            'submitted' => Application::where('status', 'Submitted')->count(),
            'review' => Application::where('status', 'Under Review')->count(),
            'approved' => Application::where('status', 'Approved')->count(),
            'rejected' => Application::where('status', 'Rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats', 'programs'));
    }

    public function show(Application $application)
    {
        return view('admin.applications.show', compact('application'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:Submitted,Under Review,Approved,Rejected',
        ]);

        $application->update([
            'status' => $request->status,
        ]);

        if (!empty($application->email)) {
            Mail::to($application->email)->send(new ApplicationStatusUpdated($application));
        }

        return back()->with('success', 'Application status updated.');
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return back()->with('success', 'Application deleted.');
    }
}