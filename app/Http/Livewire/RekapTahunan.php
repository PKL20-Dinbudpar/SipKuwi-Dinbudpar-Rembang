<?php

namespace App\Http\Livewire;

use App\Exports\RekapTahunanExport;
use App\Models\Rekap;
use App\Models\Wisata;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapTahunan extends Component
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
                
        return view('livewire.dinas.rekap-tahunan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'wisata' => $wisata,
        ]);
    }

    public function export()
    {
        return Excel::download(new RekapTahunanExport($this->tahun), 'RekapTahunan.xlsx');
    }
}
