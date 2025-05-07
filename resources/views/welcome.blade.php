@extends('layouts.app')

@section('title', 'Student Clinic Management')

@section('content')
<div x-data="data()" class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
        <div class="py-4 text-gray-500 dark:text-gray-400">
            <a class="ml-6 text-lg font-bold text-blue-600 dark:text-blue-400" href="{{ url('/') }}">
                BiT Students Clinic
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{ url('/') }}">
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('reception.register.patient') }}">
                        <span class="ml-4">Patient Registration</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.users.index') }}">
                        <span class="ml-4">User Management</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('reception.appointments.store') }}">
                        <span class="ml-4">Appointments</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.reports.inventory') }}">
                        <span class="ml-4">Inventory</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.reports.inventory') }}">
                        <span class="ml-4">Reports</span>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->isAdmin())
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.patients.index') }}">
                        <span class="ml-4">Patient Management</span>
                    </a>
                </li>
                @endif
            </ul>
            <div class="px-6 my-6">
                <button class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">
                    Quick Actions
                    <span class="ml-2" aria-hidden="true">+</span>
                </button>
            </div>
        </div>
    </aside>
    
    <!-- Mobile sidebar -->
    <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    
    <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu">
        <div class="py-4 text-gray-500 dark:text-gray-400">
            <a class="ml-6 text-lg font-bold text-blue-600 dark:text-blue-400" href="{{ url('/') }}">
                BiT Students Clinic
            </a>
            <ul class="mt-6">
                <li class="relative px-6 py-3">
                    <span class="absolute inset-y-0 left-0 w-1 bg-blue-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                    <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{ url('/') }}">
                        <span class="ml-4">Dashboard</span>
                    </a>
                </li>
                <!-- Mobile menu items (same as desktop) -->
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('reception.register.patient') }}">
                        <span class="ml-4">Patient Registration</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.users.index') }}">
                        <span class="ml-4">User Management</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('reception.appointments.store') }}">
                        <span class="ml-4">Appointments</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.reports.inventory') }}">
                        <span class="ml-4">Inventory</span>
                    </a>
                </li>
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.reports.inventory') }}">
                        <span class="ml-4">Reports</span>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->isAdmin())
                <li class="relative px-6 py-3">
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200" href="{{ route('admin.patients.index') }}">
                        <span class="ml-4">Patient Management</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </aside>
    
    <div class="flex flex-col flex-1 w-full">
        <!-- Header -->
        <header class="z-10 py-4 bg-gradient-to-r from-blue-700 to-blue-500 shadow-md dark:from-blue-900 dark:to-blue-700">
            <div class="container flex items-center justify-between h-full px-6 mx-auto text-white">
                <!-- Mobile hamburger -->
                <!-- <button
                             class="p-2 rounded-md text-gray-700 bg-black hover:bg-gray-100 border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500"
                            @click="toggleSideMenu"
                          aria-label="Menu"
>
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                            fill-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd"
                        ></path>
                           </svg>
                             </button> -->


                
                <!-- Brand -->
                <a href="{{ url('/') }}" class="text-xl font-bold text-white md:hidden">
                    BiT Students Clinic
                </a>
                
                <!-- Search input -->
                <form action="{{ route('search') }}" method="GET" class="w-full flex justify-center flex-1 lg:mr-32 relative">
                <!-- Search Icon -->
                     <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                         <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 18.5a7.5 7.5 0 006.15-3.85z"/>
                            </svg>
                        </div>

                   <!-- Search Input -->
                      <input
                   type="text"
                     name="query"
                         placeholder="Search for patients, appointments..."
                      aria-label="Search"
                      class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border border-gray-400 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       />
                     </form>

            </div>
           </header>
        
           <!-- Main content -->
            <main class="h-full overflow-y-auto">
            <div class="container px-6 mx-auto grid">
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Welcome to BiT Students Clinic Management System
                </h2>
                
                <!-- Welcome Banner -->
                <div class="p-6 mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg shadow-md border border-blue-100 dark:border-blue-900">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <!-- <div class="mb-6 md:mb-0 md:w-2/3">
                            <h3 class="text-xl font-bold text-blue-800 dark:text-blue-300 mb-2">Student Healthcare Management</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                A comprehensive solution for managing student healthcare services, appointments, and medical records.
                            </p>
                            @guest
                            <a href="{{ route('login') }}" 
                                 class="inline-block px-6 py-3 font-medium text-black text-center transition-colors duration-200 bg-blue-600 border border-transparent rounded-lg active:bg-blue-700 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue"> 
                             Login to Access System
                              </a>
                            @else
                                <span class="text-blue-700 dark:text-blue-300 font-medium">Welcome back, {{ Auth::user()->name }}!</span>
                            @endguest
                        </div> -->
                        <div class="md:w-1/3 flex justify-center">
                           
                             <img src="{{ asset('images/new-logo.jpg') }}" alt="Clinic Logo"  style="width: 60px; height: 60px; border-radius: 50%;">
                          
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Patient Registration</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Register new patients easily and manage their information</p>
                        <a href="{{ route('reception.register.patient') }}" class="inline-block w-full px-4 py-2 text-center font-medium text-black bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                            Register Patient
                        </a>
                    </div>
                    
                    <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">User Management</h3>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-4">Manage clinic staff and their permissions</p>
                        <a href="{{ route('admin.register.user') }}" class="inline-block w-full px-4 py-2 text-center font-medium text-black bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                            Manage Users
                        </a>
                    </div>
                    
                    <div class="p-6 bg-white rounded-lg shadow-md border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">Inventory</h3>
                        </div>

                        <p class="text-gray-600 dark:text-gray-300 mb-4">Track and manage medications and supplies</p>
                        <a href="{{ route('admin.reports.inventory') }}" class="inline-block w-full px-4 py-2 text-center font-medium text-black bg-purple-600 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                            Manage Inventory
                        </a>
                    </div>
                </div>
                
                <!-- Statistics Section -->
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="p-3 mr-4 bg-blue-100 rounded-full dark:bg-blue-900">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Total Patients
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                {{ \App\Models\Patient::count() ?? '0' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="p-3 mr-4 bg-green-100 rounded-full dark:bg-green-900">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Today's Appointments
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                {{ \App\Models\Appointment::whereDate('appointment_date', today())->count() ?? '0' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="p-3 mr-4 bg-orange-100 rounded-full dark:bg-orange-900">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Low Stock Items
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                {{ \App\Models\Medication::whereRaw('current_stock <= reorder_level')->count() ?? '0' }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="p-3 mr-4 bg-red-100 rounded-full dark:bg-red-900">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                                Staff Members
                            </p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                {{ \App\Models\User::count() ?? '0' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-black text-white p-6 mt-auto">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-lg font-bold mb-2">BiT Students Clinic</h3>
                        <p class="text-gray-400">Providing quality healthcare for students</p>
                    </div>
                    <div class="flex space-x-6">
                        <div>
                            <h4 class="font-semibold mb-2">Quick Links</h4>
                            <ul class="space-y-1">
                                <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition">Home</a></li>
                                <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">Contact</h4>
                            <ul class="space-y-1">
                                <li class="text-gray-400">Email: info@bitstudentsclinic.com</li>
                                <li class="text-gray-400">Phone: +123-456-7890</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-6 pt-6 text-center text-gray-500">
                    <p>&copy; {{ date('Y') }} BiT Students Clinic. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>

<script>
    function data() {
        return {
            isSideMenuOpen: false,
            toggleSideMenu() {
                this.isSideMenuOpen = !this.isSideMenuOpen
            },
            closeSideMenu() {
                this.isSideMenuOpen = false
            },
            isNotificationsMenuOpen: false,
            toggleNotificationsMenu() {
                this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
            },
            closeNotificationsMenu() {
                this.isNotificationsMenuOpen = false
            },
            isProfileMenuOpen: false,
            toggleProfileMenu() {
                this.isProfileMenuOpen = !this.isProfileMenuOpen
            },
            closeProfileMenu() {
                this.isProfileMenuOpen = false
            },
            isDark: false,
            toggleTheme() {
                this.isDark = !this.isDark
                document.documentElement.classList.toggle('dark', this.isDark)
            }
        }
    }
</script>
@endsection












