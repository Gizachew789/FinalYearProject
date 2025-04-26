@extends('layouts.app')

@section('content')
<h2>Medication Added Successfully</h2>

<p>The medication <strong>{{ $medication->name }}</strong> has been saved.</p>

<a href="{{ route('admin.inventory.index') }}">Back to Inventory</a>
<a href="{{ route('admin.inventory.create') }}">Add Another</a>
<a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary">View All Medications</a>
@endsection
