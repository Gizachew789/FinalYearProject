@extends('layouts.app')

@section('content')
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tbody>
                            @forelse($appointments ?? [] as $appointments)
                                <tr>
                                    <td>{{ $appointments->patient->name }}</td>
                                    <td>{{ $appointments->appointment_date }}</td>
                                    <td>{{ $appointments->appointment_time }}</td>
                                    <td>
                                        @if($appointments->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($appointments->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($appointments->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($appointments->status == 'pending')
                                            <form method="POST" action="{{ route('staff.appointments.accept', $appointments->patient_id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success mb-1">Accept</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('staff.patients.show', $appointments->patient_id) }}" class="btn btn-sm btn-primary mb-1" 
                                           onclick="loadPatientDetails('{{ $appointments->patient_id }}')">View</a>
                                        <a href="{{ route('staff.lab-requests.create', $appointments->patient_id) }}" class="btn btn-sm btn-outline-secondary mb-1"
                                           onclick="prepareLabRequest('{{ $appointments->patient_id }}')">Lab Test</a>
                                        <a href="{{ route('staff.prescriptions.create', $appointments->patient_id) }}" class="btn btn-sm btn-outline-secondary"
                                           onclick="preparePrescription('{{ $appointments->patient_id }}')">Prescribe</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No appointments available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
@endsection