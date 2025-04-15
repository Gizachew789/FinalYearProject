<?php
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventory Item Details</h1>
    <p>Details for inventory item: {{ $item->name }}</p>
    <p>Price: {{ $item->price }}</p>
    <p>Quantity: {{ $item->quantity }}</p>
    <p>Description: {{ $item->description }}</p>
</div>
@endsection