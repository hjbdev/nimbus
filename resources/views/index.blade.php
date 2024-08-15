@extends('nimbus::layout')

@section('title', 'Dashboard')

@section('content')
<x-nimbus::card flush class="grid md:grid-cols-3 divide-x">
    <div class="p-4">
        <div class="text-6xl font-semibold mb-2">{{ $exceptions_last_hour }}</div>
        <div class="opacity-75">Exceptions (1h)</div>
    </div>
    <div class="p-4">
        <div class="text-6xl font-semibold mb-2">{{ $exceptions_last_24_hours }}</div>
        <div class="opacity-75">Exceptions (24h)</div>
    </div>
    <div class="p-4">
        <div class="text-6xl font-semibold mb-2">{{ $exceptions_last_week }}</div>
        <div class="opacity-75">Exceptions (7 days)</div>
    </div>
</x-nimbus::card>
@endsection