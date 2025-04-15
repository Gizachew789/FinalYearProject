<?php
@extends('layouts.app')

@section('content')
<div class="container" role="main">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    <x-alert />

                    <div class="row">
                        <!-- Staff Management -->
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title" title="Includes managing physicians, receptionists, lab technicians, and pharmacists.">Staff Management</h5>
                                    <p class="card-text">{{ __('Manage staff members including physicians, reception, lab technicians, and pharmacists.') }}</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">{{ __('Manage Staff') }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- Register New Staff -->
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Register New Staff') }}</h5>
                                    <p class="card-text">{{ __('Add a new staff member to the system.') }}</p>
                                    <a href="{{ route('admin.register.user') }}" class="btn btn-success">{{ __('Register Staff') }}</a>
                                </div>
                            </div>
                        </div>

                        <!-- Reports -->
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Reports') }}</h5>
                                    <p class="card-text">{{ __('View and generate system reports.') }}</p>
                                    <a href="{{ route('admin.reports.appointments') }}" class="btn btn-info">{{ __('View Reports') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

