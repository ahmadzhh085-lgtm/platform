<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // تأكد من وجود ملف قاعدة البيانات SQLite
        if (config('database.default') === 'sqlite') {
            $database = config('database.connections.sqlite.database');

            if ($database && $database !== ':memory:' && ! file_exists($database)) {
                $directory = dirname($database);

                if ($directory !== '.' && $directory !== '' && ! is_dir($directory)) {
                    @mkdir($directory, 0755, true);
                }

                @touch($database);
            }
        }
    }
}
