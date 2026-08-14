<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\MigrateImagesToCloudinary::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Define scheduled tasks here if needed
    }

    protected function commands()
    {
        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}
