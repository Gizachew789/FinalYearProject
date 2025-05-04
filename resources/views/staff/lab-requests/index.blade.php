{{-- resources/views/lab_technician/lab_requests/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Lab Requests</h1>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Patient</th>
                <th class="px-4 py-2">Requested By</th>
                <th class="px-4 py-2">Test Type</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labRequests as $request)
                <tr>
                    <td class="px-4 py-2">{{ $request->patient->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->requestedBy->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->test_type }}</td>
                    <td class="px-4 py-2">{{ $request->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('lab-technician.requests.show', $request->id) }}" class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
