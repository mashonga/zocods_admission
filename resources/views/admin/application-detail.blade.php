@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Application Details</h2>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Full Name</p>
                    <p class="font-medium">{{ $application->full_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $application->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $application->phone }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Program</p>
                    <p class="font-medium">{{ $application->program }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Gender</p>
                    <p class="font-medium">{{ $application->gender ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Date of Birth</p>
                    <p class="font-medium">{{ $application->date_of_birth ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium">{{ $application->address ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">District</p>
                    <p class="font-medium">{{ $application->district ?? 'N/A' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-500">Status</p>
                    <form action="/admin/applications/{{ $application->id }}/status" method="POST" class="flex items-center space-x-2">
                        @csrf
                        <select name="status" class="rounded border p-1">
                            <option value="Pending Payment" @if($application->status == 'Pending Payment') selected @endif>Pending Payment</option>
                            <option value="Paid" @if($application->status == 'Paid') selected @endif>Paid</option>
                            <option value="Approved" @if($application->status == 'Approved') selected @endif>Approved</option>
                            <option value="Rejected" @if($application->status == 'Rejected') selected @endif>Rejected</option>
                        </select>
                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded text-sm">Update</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-xl font-semibold mb-4">Documents</h2>
            @if($application->certificate_file)
                <a href="{{ asset('storage/' . $application->certificate_file) }}" target="_blank" class="text-blue-600 hover:underline block">Certificate File</a>
            @endif
            @if($application->id_file)
                <a href="{{ asset('storage/' . $application->id_file) }}" target="_blank" class="text-blue-600 hover:underline block">ID File</a>
            @endif
        </div>
    </div>
    
    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Payment Information</h2>
            @if($application->payment)
                <div class="space-y-2">
                    <p><span class="text-gray-500">Reference:</span> {{ $application->payment->reference }}</p>
                    <p><span class="text-gray-500">Amount:</span> <span class="font-bold">ZMW {{ number_format($application->payment->amount, 2) }}</span></p>
                    <p><span class="text-gray-500">Status:</span> 
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($application->payment->status == 'paid') bg-green-100 text-green-800
                            @elseif($application->payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $application->payment->status }}
                        </span>
                    </p>
                    @if($application->payment->paid_at)
                        <p><span class="text-gray-500">Paid At:</span> {{ $application->payment->paid_at->format('Y-m-d H:i') }}</p>
                    @endif
                    @if($application->payment->transaction_id)
                        <p><span class="text-gray-500">Transaction ID:</span> {{ $application->payment->transaction_id }}</p>
                    @endif
                </div>
            @else
                <p class="text-gray-500">No payment record found</p>
            @endif
        </div>
        
        <div class="bg-white rounded-lg shadow p-6 mt-6">
            <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
            <a href="/admin/applications" class="block text-blue-600 hover:underline">← Back to Applications</a>
        </div>
    </div>
</div>
@endsection
