<?php

namespace App\Console;

use App\Models\Hotel;
use App\Models\Rekap;
use App\Models\Wisata;
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
        $hour = config('app.hour');
        $min = config('app.min');
        $scheduledInterval = $hour !== '' ? ( ($min !== '' && $min != 0) ?  $min .' */'. $hour .' * * *' : '0 */'. $hour .' * * *') : '*/'. $min .' * * * *';
        if (env('IS_DEMO')) {
            $schedule->command('migrate:fresh --seed')->cron($scheduledInterval);
        }

        $schedule->call(function () {
            $wisata = Wisata::all();
            foreach ($wisata as $w) {
                $rekap = new Rekap;
                $rekap->tanggal = date('Y-m-d');
                $rekap->id_wisata = $w->id_wisata;
                $rekap->wisatawan_domestik = 0;
                $rekap->wisatawan_mancanegara = 0;
                $rekap->total_pendapatan = 0;
                $rekap->save();
            }
        })->dailyAt('09.00');
        
        $schedule->call(function () {
            $hotel = Hotel::all();
            foreach ($hotel as $h) {
                $rekap = new Rekap;
                $rekap->tanggal = date('Y-m-d');
                $rekap->id_hotel = $h->id_hotel;
                $rekap->hotel_domestik = 0;
                $rekap->hotel_mancanegara = 0;
                $rekap->total_pendapatan = 0;
                $rekap->save();
            }
        })->dailyAt('09.00');
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Jakarta';
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
