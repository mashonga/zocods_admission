<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use App\Models\Program;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalApplications = Application::count();
        $paidApplications = Application::where('status', 'Paid')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $recentApplications = Application::with('payment')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalApplications',
            'paidApplications',
            'pendingPayments',
            'totalRevenue',
            'recentApplications'
        ));
    }

    public function applications()
    {
        $applications = Application::with('payment')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.applications', compact('applications'));
    }

    public function showApplication($id)
    {
        $application = Application::with('payment')->findOrFail($id);
        return view('admin.application-detail', compact('application'));
    }

    public function payments()
    {
        $payments = Payment::with('application')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.payments', compact('payments'));
    }

    public function programs()
    {
        $programs = Program::orderBy('name')->get();
        return view('admin.programs', compact('programs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $application = Application::findOrFail($id);
        $application->status = $request->status;
        $application->save();

        return redirect()->back()->with('success', 'Application status updated!');
    }
}
