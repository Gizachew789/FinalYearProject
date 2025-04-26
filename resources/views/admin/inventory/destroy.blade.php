@extends('layouts.app')

@section('content')
<h2>Delete Medication</h2>

<p>Are you sure you want to delete <strong>{{ $medication->name }}</strong>?</p>

<form method="POST" action="{{ route('admin.inventory.destroy', $medication->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Yes, Delete</button>
    <a href="{{ route('admin.inventory.index') }}">Cancel</a>
</form>
@endsection
