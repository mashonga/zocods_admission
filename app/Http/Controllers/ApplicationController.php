<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationStatusUpdated;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function create()
    {
        return view('apply');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'program' => 'required|string|max:255',
            'address' => 'nullable|string',
            'highest_qualification' => 'nullable|string|max:255',
            'previous_school' => 'nullable|string|max:255',
            'certificate_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'message' => 'nullable|string',
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

        $stats = [
            'total' => Application::count(),
            'submitted' => Application::where('status', 'Submitted')->count(),
            'review' => Application::where('status', 'Under Review')->count(),
            'approved' => Application::where('status', 'Approved')->count(),
            'rejected' => Application::where('status', 'Rejected')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats'));
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