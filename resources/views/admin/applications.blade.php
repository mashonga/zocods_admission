@extends('layouts.admin')

@section('title', 'Applications')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Applications</h2>
        <span class="text-sm text-gray-500">Total: {{ $applications->total() }}</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-medium">{{ $app->full_name }}</td>
                    <td class="px-6 py-4 text-sm">{{ $app->email ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $app->program }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($app->status == 'Paid') bg-green-100 text-green-800
                            @elseif($app->status == 'Pending Payment') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $app->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($app->payment)
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($app->payment->status == 'paid') bg-green-100 text-green-800
                                @elseif($app->payment->status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $app->payment->status }}
                            </span>
                            <br>
                            <span class="text-xs text-gray-500">ZMW {{ number_format($app->payment->amount, 2) }}</span>
                        @else
                            <span class="text-gray-400 text-xs">No payment</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $app->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="/admin/applications/{{ $app->id }}" class="text-blue-600 hover:text-blue-800 mr-2">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No applications found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection
