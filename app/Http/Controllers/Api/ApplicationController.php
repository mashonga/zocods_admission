<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Mail\ApplicationStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
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

        return response()->json([
            'applications' => $applications,
            'stats' => $stats,
        ]);
    }

    public function show(Application $application)
    {
        return response()->json($application);
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

        return response()->json([
            'message' => 'Application status updated.',
            'application' => $application
        ]);
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return response()->json(['message' => 'Application deleted.']);
    }
}
