<?php

namespace Hjbdev\Nimbus;

use Hjbdev\Nimbus\Components\Card;
use Hjbdev\Nimbus\Models\Exception;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
// use Hjbdev\Nimbus\Commands\NimbusCommand;

class NimbusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('nimbus')
            ->hasConfigFile()
            ->hasRoutes('web')
            ->hasAssets()
            ->hasViewComponents('nimbus', Card::class)
            ->hasViews()
            ->hasMigration('create_nimbus_tables')
            ->runsMigrations();
    }

    public function boot()
    {
        parent::boot();

        if (config('nimbus.enabled') === false) {
            return;
        }

        $this->callAfterResolving(Gate::class, function (Gate $gate, Application $app) {
            $gate->define('viewNimbus', fn($user = null) => $app->environment('local'));
        });

        $this->callAfterResolving(Handler::class, function (Handler $handler) {
            $handler->reportable(function (\Throwable $throwable) {
                try {
                    /** @var \Hjbdev\Nimbus\Models\Exception $exception */
                    DB::beginTransaction();

                    $file = str($throwable->getFile())->replace('\\', '/')->replace(base_path(), '');

                    if ($file->startsWith('/')) {
                        $file = $file->substr(1);
                    }

                    $exception = Exception::create([
                        'message' => $throwable->getMessage(),
                        'code' => $throwable->getCode(),
                        'file' => $file->toString(),
                        'line' => $throwable->getLine(),
                    ]);

                    collect($throwable->getTrace())->each(function ($traceLine, $index) use ($exception) {
                        $file = str($traceLine['file'] ?? '')->replace(base_path(), '')->replace('\\', '/');

                        if ($file->startsWith('/')) {
                            $file = $file->substr(1);
                        }

                        $exception->traceLines()->create([
                            'index' => $index,
                            'file' => $file->toString(),
                            'line' => $traceLine['line'] ?? null,
                            'function' => $traceLine['function'] ?? null,
                            'args' => $traceLine['args'] ?? false ? json_encode($traceLine['args']) : null,
                            'created_at' => now(),
                        ]);
                    });

                    DB::commit();
                } catch (\Throwable $e) {
                    // Do nothing
                }
                return true;
            });
        });
    }
}
