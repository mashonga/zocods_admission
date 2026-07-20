@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">All Payments</h2>
        <span class="text-sm text-gray-500">Total: {{ $payments->total() }}</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 text-sm font-mono">{{ $payment->reference }}</td>
                    <td class="px-6 py-4 text-sm">{{ $payment->application->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-sm font-semibold">ZMW {{ number_format($payment->amount, 2) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($payment->status == 'paid') bg-green-100 text-green-800
                            @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $payment->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="/admin/applications/{{ $payment->application_id }}" class="text-blue-600 hover:text-blue-800">View Application</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No payments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $payments->links() }}
    </div>
</div>
@endsection
