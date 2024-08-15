@extends('nimbus::layout')

@section('title', 'Exceptions')

@section('content')

@if (request()->has('file'))
    <div class="flex items-center gap-2 mb-3">
        <div class="border border-purple-500 rounded px-2 py-0.5 text-sm">
            <span class="font-bold">File:</span>
            {{ request('file')}}
        </div>
    </div>
@endif

<x-nimbus::card class="space-y-1 py-4" flush>
    @if ($exceptions->isEmpty())
    <div class="text-center opacity-50">We haven't recorded any exceptions!</div>
    @endif
    @foreach ($exceptions as $exception)
    <div class="flex py-1 relative hover:bg-zinc-100 dark:bg-zinc-800 transition px-4">
        <div>
            <div>
                {{ $exception->message }}
            </div>
            <div class="text-xs opacity-50">
                {{ str($exception->file)->afterLast('/') }}:{{ $exception->line }} &bull; {{ $exception->trace_lines_count }} lines
            </div>
        </div>
        <div class="ml-auto flex items-center gap-2">
            <span class="text-xs opacity-50" title="{{ $exception->created_at->format('Y-m-d H:i:s') }}">{{ $exception->created_at->diffForHumans() }}</span>
        </div>
        <a href="/nimbus/exceptions/{{ $exception->id }}" class="absolute inset-0"></a>
    </div>
    @endforeach
</x-nimbus::card>

<div class="mt-4">
    {{ $exceptions->links() }}
</div>
@endsection