
@extends('layouts.app')

@section('content')
<div class="container" role="main">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <!-- This component displays alert messages, such as success or error notifications -->
                    <!-- For customization or further details, refer to the documentation: https://laravel.com/docs/8.x/blade#components -->
                  

                    <div class="row">
                        @php
                            $cards = [
                                [
                                    'title' => 'Staff Management',
                                    'text' => 'Manage staff members including physicians, reception, lab technicians, and pharmacists.',
                                    'route' => route('admin.users.index'),
                                    'button' => 'Manage Staff',
                                    'class' => 'btn-primary'
                                ],
                                [
                                    'title' => 'Register New User',
                                    'text' => 'Add a new staff member to the system.',
                                    'route' => route('admin.register.user'),
                                    'button' => 'Register New User',
                                    'class' => 'btn-success'
                                ],
                                [
                                    'title' => 'Appointment Reports',
                                    'text' => 'View and generate reports related to appointments.',
                                    'route' => route('admin.reports.appointments'),
                                    'button' => 'View Appointment Reports',
                                    'class' => 'btn-info'
                                ],
                                [
                                    'title' => 'Inventory Management',
                                    'text' => 'Manage and monitor inventory items.',
                                    'route' => route('admin.inventory.index'),
                                    'button' => 'Manage Inventory',
                                    'class' => 'btn-warning'
                                ],
                                [
                                    'title' => 'Reception Management',
                                    'text' => 'Manage reception-related tasks and patient registrations.',
                                    'route' => route('reception.register.patient'),
                                    'button' => 'Reception Management',
                                    'class' => 'btn-secondary'
                                ],
                            ];
                        @endphp
                    
                        @foreach ($cards as $card)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ __($card['title']) }}</h5>
                                        <p class="card-text">{{ __($card['text']) }}</p>
                                        <a href="{{ $card['route'] }}" class="btn {{ $card['class'] }}">{{ __($card['button']) }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endsection