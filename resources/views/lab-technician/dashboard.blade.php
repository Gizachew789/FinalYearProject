{{-- resources/views/lab_technician/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h3 class="text-center">Lab Technician Dashboard</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- View Lab Test Requests --}}
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h5 class="text-xl font-semibold mb-4 text-indigo-600">View Lab Test Requests</h5>
            <p class="text-gray-600 mb-4">Review and accept pending lab test requests submitted by Nurses and Health Officers.</p>
            <a href="{{ route('lab.requests.index') }}" 
                class="bg-indigo-600 hover:bg-indigo-700 text-black font-semibold px-5 py-3 rounded">
                See Test Requests
            </a>
        </div>

        {{-- Upload Lab Test Results --}}
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h5 class="text-xl font-semibold mb-4 text-green-700">Upload Lab Test Results</h5>
            <p class="text-gray-600 mb-4">Upload results for confirmed lab test requests to make them visible to Nurses and Health Officers.</p>
            <a href="{{ route('lab.results.create') }}" 
                class="bg-green-600 hover:bg-green-700 text-black font-semibold px-5 py-3 rounded">
                Upload Results
            </a>
        </div>

        {{-- New Section for Viewing Lab Test Results --}}
        @foreach($patient->results as $result)
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <h5 class="text-xl font-semibold mb-4 text-blue-600">View Lab Test Results for {{ $result->test_name }}</h5>
            <p class="text-gray-600 mb-4">Access and review the results of lab tests that have been uploaded.</p>
            <a href="{{ route('lab.results.index', ['patient_id'=> $patient->patient_id]) }}" 
                class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-5 py-3 rounded">
                See Test Results
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
