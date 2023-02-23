<?php

namespace App\Console;

use App\Models\Hotel;
use App\Models\Rekap;
use App\Models\RekapHotel;
use App\Models\RekapWisata;
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
        $schedule->call(function () {
            $wisata = Wisata::all();
            foreach ($wisata as $w) {
                $rekap = new RekapWisata();
                $rekap->tanggal = date('Y-m-d');
                $rekap->id_wisata = $w->id_wisata;
                $rekap->wisatawan_nusantara = 0;
                $rekap->wisatawan_mancanegara = 0;
                $rekap->total_pendapatan = 0;
                $rekap->save();
            }

            $hotel = Hotel::all();
            foreach ($hotel as $h) {
                $rekap = new RekapHotel();
                $rekap->tanggal = date('Y-m-d');
                $rekap->id_hotel = $h->id_hotel;
                $rekap->pengunjung_nusantara = 0;
                $rekap->pengunjung_mancanegara = 0;
                $rekap->kamar_terjual = 0;
                $rekap->save();
            }
        })->dailyAt('00.00');
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
