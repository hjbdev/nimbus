<?php

use Hjbdev\Nimbus\Middleware\Authorize;
use Hjbdev\Nimbus\Models\Exception;
use Hjbdev\Nimbus\Models\TraceLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::prefix(config('nimbus.route.prefix', 'nimbus'))->middleware([Authorize::class, ...config('nimbus.route.middleware', ['web'])])->group(function () {
    Route::get('/', function () {
        return view('nimbus::index', [
            'exceptions_last_week' => Exception::where('created_at', '>=', now()->subWeek())->count(),
            'exceptions_last_24_hours' => Exception::where('created_at', '>=', now()->subDay())->count(),
            'exceptions_last_hour' => Exception::where('created_at', '>=', now()->subHour())->count(),
        ]);
    })->name('nimbus.index');

    Route::get('exceptions', function (Request $request) {
        $request->validate([
            'file' => ['nullable', 'string', 'max:500'],
        ]);

        $query = Exception::latest()->withCount('traceLines');

        if ($request->has('file')) {
            $query = $query->where('file', $request->file);
        }

        return view('nimbus::exceptions.index', [
            'exceptions' => $query->paginate(20),
        ]);
    })->name('nimbus.exceptions.index');

    Route::get('exceptions-by-file', function (Request $request) {
        $request->validate([
            'time' => ['nullable', 'string', 'in:week,day,hour,all'],
        ]);

        $exceptions = Exception::query()
            ->select('file', DB::raw('count(*) as count'))
            ->where('file', 'NOT LIKE', 'vendor/%')
            ->groupBy('file');

        match($request->time) {
            'week' => $exceptions = $exceptions->where('created_at', '>=', now()->subWeek()),
            'day' => $exceptions = $exceptions->where('created_at', '>=', now()->subDay()),
            'hour' => $exceptions = $exceptions->where('created_at', '>=', now()->subHour()),
            default => null,
        };

        return view('nimbus::exceptions.by-file', [
            'exceptions' => $exceptions->paginate(20),
        ]);
    })->name('nimbus.exceptions.by-file');

    Route::get('exceptions/{exception}', function ($id) {
        $exception = Exception::with('traceLines')->findOrFail($id);

        // get contents of the file
        if (file_exists($exception->file)) {
            $file = file_get_contents($exception->file);
        } else if(file_exists(base_path($exception->file))) {
            $file = file_get_contents(base_path($exception->file));
        } else {
            $file = null;
        }

        $end = 0;

        if ($file) {
            $file = explode("\n", $file);

            // get the 10 lines before and after the exception
            $start = max($exception->line - 10, 0);
            $end = min($exception->line + 10, count($file));
            $file = array_slice($file, $start, $end - $start, true);
            
            // highlight the line of the exception
            // $file[$exception->line - 1] = '<span class="bg-red-500 text-white">' . $file[$exception->line - 1] . '</span>';
        }

        return view('nimbus::exceptions.show', [
            'exception' => $exception,
            'file' => $file,
            'fileEnd' => $end ?? 0,
        ]);
    })->name('nimbus.exceptions.show');
});
