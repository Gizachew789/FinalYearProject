{{-- resources/views/reception/dashboard.blade.php --}}
@extends('layouts.app') {{-- since you are extending app.blade.php directly, not layouts.app --}}

@section('content')
<div class="container mx-auto p-4">

    <h1  class="text-3xl mb-6 text-center text-gray-10">Reception Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Register New Patient --}}
        <div class="bg-brown rounded-lg shadow-lg p-6 text-center">
            <p>
                <span class="text-gray-200 mb-4">Register new patients and manage their information easily.</span>
            </p>
            <a href="{{ route('reception.register.patient') }}" 
                class="inline-block bg-blue-600 hover:bg-blue-700 text-black text-sm font-semibold px-6 py-3 rounded transition">
                Register Patient
            </a>
         </div>
              {{-- Book Appointment --}}
            <div class="bg-gray rounded-lg shadow-lg p-3 text-center">
                  <p class="text-gray-200 mb-4">Find registered patients and schedule their appointments easily.</p>
                  <a href="{{ route('reception.appointments.store') }}" 
                 class="inline-block bg-green-600 hover:bg-green-100 text-black text-sm font-semibold px-6 py-3 rounded transition">
                      Book Appointment
                     </a>
            </div>

            {{-- Book Appointment --}}
            <div class="bg-purple rounded-lg shadow-lg p-3 text-center">
                  <p class="text-gray-200 mb-4">Show and manage upcoming appointments easily.</p>
                  <a href="{{ route('reception.appointments.index') }}" 
                 class="inline-block bg-green-600 hover:bg-green-100 text-black text-sm font-semibold px-6 py-3 rounded transition">
                      See Appointment
                     </a>
            </div>
    </div>

</div>
@endsection
