@extends('nimbus::layout')

@section('title', 'Exceptions')

@section('content')
<x-nimbus::card>
    <header class="mb-6">
        <h2 class="text-3xl">{{ $exception->message }}</h2>
        <div class="opacity-50">
            {{ $exception->file }}:{{ $exception->line }}
        </div>
    </header>

    @if ($file)
    {{-- bg-red-500 text-white --}}
    <pre class="mb-6 overflow-x-auto bg-zinc-950 text-white rounded-md"><code>@foreach ($file as $lineIndex => $line)<span class="opacity-50 select-none">{{ str_pad($lineIndex + 1, strlen($fileEnd + 1), '0', STR_PAD_LEFT) }} </span><span @class(['bg-red-600 text-white' => $exception->line === intval($lineIndex) + 1])>{{ $line }}</span>@endforeach</code></pre>
    @endif

    <section x-data="{ vendorVisible: true }">
        <header class="flex gap-3 items-center mb-3">
            <h3 class="text-xl font-semibold">Stack Trace</h3>
            <button x-on:click="vendorVisible = !vendorVisible" class="text-sm">
                <span x-show="vendorVisible">Hide vendor</span>
                <span x-show="!vendorVisible">Show vendor</span>
            </button>
        </header>

        @foreach ($exception->traceLines as $traceLine)
        <div @if(str($traceLine->file)->startsWith('vendor/')) x-show="vendorVisible" @endif class="flex items-center gap-2 mb-2">
            <div class="w-8 min-w-8 text-sm opacity-50">{{ $traceLine->index }}</div>
            <div class="truncate">
                <div class="truncate">
                    {{ $traceLine->file }}:{{ $traceLine->line }}
                </div>
                <div class="text-xs opacity-50">
                    {{ $traceLine->class }}{{ $traceLine->type }}{{ $traceLine->function }}()
                </div>
                @if ($traceLine->args)
                <div class="text-xs opacity-50 mt-0.5">args: {{ collect($traceLine->args)->implode(', ') }}</div>
                @endif
            </div>
        </div>
        @endforeach
    </section>
</x-nimbus::card>
@endsection