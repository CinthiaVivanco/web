<?php

namespace App\Console;

use App\Console\Commands\DesactivarReglas;
use App\Console\Commands\RedesSociales;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DesactivarReglas::class,
        RedesSociales::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('desactivarreglas:desactivarreglasContrato')->everyMinute(); // CADA MINUTO
        //$schedule->command('redessociales:publicidadredessociales')->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
