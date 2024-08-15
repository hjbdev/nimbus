@extends('nimbus::layout')

@section('title', 'Exceptions by File')

@section('content')

<div class="flex gap-2 mb-3">
    <a href="?time=week" @class(["rounded border inline-block bg-white py-0.5 px-3", "border-purple-500" => request('time') === 'week'])>Last 7 Days</a>
    <a href="?time=day" @class(["rounded border inline-block bg-white py-0.5 px-3", "border-purple-500" => request('time') === 'day'])>Last 24h</a>
    <a href="?time=hour" @class(["rounded border inline-block bg-white py-0.5 px-3", "border-purple-500" => request('time') === 'hour'])>Last Hour</a>
    <a href="?time=all" @class(["rounded border inline-block bg-white py-0.5 px-3", "border-purple-500" => !request('time') || request('time') === 'all'])>All</a>
</div>

<x-nimbus::card class="space-y-1 py-4" flush>
    @if ($exceptions->isEmpty())
    <div class="text-center opacity-50">We haven't recorded any exceptions!</div>
    @endif
    @foreach ($exceptions as $exception)
    <div class="flex py-1 relative hover:bg-zinc-100 dark:bg-zinc-800 transition px-4">
        <div>
            {{ $exception->file }}
        </div>
        <div class="ml-auto text-lg">{{ $exception->count }}</div>
        <a href="/nimbus/exceptions/?file={{ urlencode($exception->file) }}" class="absolute inset-0"></a>
    </div>
    @endforeach
</x-nimbus::card>

<div class="mt-4">
    {{ $exceptions->links() }}
</div>
@endsection