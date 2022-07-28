<?php

namespace App\Console;

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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* 
        * * * * * cd /var/www/simosan.syaddamm.com/htdocs && php artisan schedule:run >> /dev/null 2>&1
        */

        $schedule->call('Modules\Bridging\Http\Controllers\SiranapControlller@process')->twiceDaily(11,18);

        // $schedule->call('Modules\PresensiJamaah\Http\Controllers\PresensiJamaahController@store')->dailyAt(configuration('GENERATE_PRESENSI'));
        // $schedule->call('Modules\PresensiMalam\Http\Controllers\PresensiMalamController@store')->dailyAt(configuration('GENERATE_PRESENSI'));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
