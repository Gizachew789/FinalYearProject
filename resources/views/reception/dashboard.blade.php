{{-- resources/views/reception/dashboard.blade.php --}}
@extends('layouts.app') {{-- since you are extending app.blade.php directly, not layouts.app --}}

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Reception Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Register New Patient --}}
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Register New Patient</h2>


            <a href="{{ route('reception.register.patient') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-black text-sm font-semibold px-6 py-3 rounded transition">
                Register Patient
            </a>
        </div>

        {{-- Book Appointment --}}
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <h2 class="text-xl font-semibold mb-4 text-green-700">Book Appointment</h2>
            <p class="text-gray-600 mb-6">Find registered patients and schedule their appointments easily.</p>

            <a href="{{ route('reception.appointments.store') }}" 
                class="inline-block bg-green-600 hover:bg-green-700 text-black text-sm font-semibold px-6 py-3 rounded transition">
                Book Appointment
            </a>
        </div>

    </div>

</div>
@endsection
