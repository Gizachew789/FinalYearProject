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
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labRequests as $request)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $request->patient->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->requestedBy->name ?? 'Unknown' }}</td>
                    <td class="px-4 py-2">{{ $request->test_name }}</td>
                    <td class="px-4 py-2">{{ $request->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">
                        @if ($request->patient)
                            <a href="{{ route('staff.lab-requests.show', ['patient_id' => $request->patient->patient_id]) }}"
                               class="text-blue-600 hover:underline">View</a>
                                @else
                            <span class="text-gray-500">No patient</span>
                        @endif
                                 </td>
                            </tr>
                  @endforeach

                            <!-- Form to record test result -->
                            <form action="{{ route('lab.results.store') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{ $request->patient->patient_id }}">
                                <input type="hidden" name="test_name" value="{{ $request->test_name }}">

                                <div class="mb-1">
                                    <label class="block text-sm">Disease Type</label>
                                    <input type="text" name="disease_type" required class="border px-2 py-1 w-full">
                                </div>

                                <div class="mb-1">
                                    <label class="block text-sm">Sample Type</label>
                                    <input type="text" name="sample_type" required class="border px-2 py-1 w-full">
                                </div>

                                <div class="mb-1">
                                    <label class="block text-sm">Result</label>
                                    <label><input type="radio" name="result" value="positive" required> Positive</label>
                                    <label><input type="radio" name="result" value="negative" required> Negative</label>
                                </div>

                                <div class="mb-1">
                                    <label class="block text-sm">Recommendation (optional)</label>
                                    <textarea name="Recommendation" rows="2" class="border px-2 py-1 w-full"></textarea>
                                </div>

                                <button type="submit" class="mt-1 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                    Submit Result
                                </button>
                            </form>
                       
                  
        </tbody>
    </table>
</div>
@endsection
