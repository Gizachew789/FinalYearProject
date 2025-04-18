@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Reception Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    {{-- Optional: Hide Blade-based buttons if you're using React for everything --}}
                    {{-- Or keep them as fallback UI --}}
                    <div class="row mt-4">
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Patient Management</h5>
                                    <p class="card-text">Manage patient records and information.</p>
                                    <a href="" class="btn btn-primary">Manage Patients</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Register New Patient</h5>
                                    <p class="card-text">Add a new patient to the system.</p>
                                    <a href="{{ route('reception.register.patient') }}" class="btn btn-success">Register Patient</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Appointments</h5>
                                    <p class="card-text">Manage patient appointments.</p>
                                    <a href="#" class="btn btn-info">Manage Appointments</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 👇 React will render inside this div --}}
                    <div id="reception-root"></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@viteReactRefresh
@vite('resources/js/app.jsx')