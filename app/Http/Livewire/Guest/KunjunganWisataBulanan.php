<?php

namespace App\Http\Livewire\Guest;

use App\Models\Rekap;
use App\Models\Wisata;
use Livewire\Component;

class KunjunganWisataBulanan extends Component
{
    public $tahun;
    public $totalWisatawan;
    public $totalPendapatan;
    
    public function mount()
    {
        $this->tahun = date('Y');
    }

    public function render()
    {
        $bulan = Rekap::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('wisata', 'rekap.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = Rekap::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_domestik) wisatawan_domestik, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_wisata', 'bulan', 'tahun')
                ->get();

        $wisata = Wisata::all();

        return view('livewire.guest.kunjungan-wisata-bulanan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'wisata' => $wisata,
        ]);
    }
}
