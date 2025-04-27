@extends('app')

@section('title', 'Student Clinic Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
       

        <div class="space-y-6 text-center">
            <a href="{{ route('reception.register.patient') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-black text-sm font-medium px-6 py-3 rounded shadow transition">
                Register Patient
            </a>

            <div>
                <h2 class="text-2xl font-semibold text-[#1b1b18] dark:text-white"></h2>
                <p class="text-gray-600 dark:text-gray-400"></p>
            </div>

            <a href="{{ route('admin.register.user') }}" class="inline-block bg-green-600 hover:bg-green-700 text-black text-sm font-medium px-6 py-3 rounded shadow transition">
                Register User
            </a>
        </div>
    </div>
@endsection
