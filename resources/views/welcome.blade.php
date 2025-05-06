@extends('layouts.app')

@section('title', 'Student Clinic Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
    @guest
                    <li class="nav-item">
                        <a class="nav-link bg-color-500" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest

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
