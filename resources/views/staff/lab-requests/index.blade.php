@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Lab Requests</h1>

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Patient</th>
                <th class="px-4 py-2">Requested By</th>
                <th class="px-4 py-2">Test Type</th>
                <th class="px-4 py-2">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labRequests as $request)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $request->patient->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->requestedBy->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->test_name }}</td>
                    <td class="px-4 py-2">{{ $request->created_at->format('Y-m-d') }}</td>
                 </tr>
                  @endforeach        
        </tbody>
    </table>
</div>
@endsection
