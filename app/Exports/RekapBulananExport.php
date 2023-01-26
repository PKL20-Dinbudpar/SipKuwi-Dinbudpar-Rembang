<?php

namespace App\Exports;

use App\Http\Livewire\DinasHome;
use App\Http\Livewire\RekapBulanan;
use App\Models\Rekap;
use App\Models\Wisata;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RekapBulananExport extends DinasHome implements FromView
{
    public $bulan;
    public $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $tanggal = Rekap::with('wisata')
                ->leftjoin('wisata', 'rekap.id_wisata', '=', 'wisata.id_wisata')
                ->select('tanggal')
                ->whereMonth('tanggal', '=', $this->bulan)
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('tanggal')
                ->get();
        
        $rekap = Rekap::with('wisata')
                ->join('wisata', 'rekap.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->whereMonth('tanggal', '=', $this->bulan)
                ->get();
        
        $wisata = Wisata::all();

        return view('components.tables.tabel-rekap-bulanan', [
            'rekap' => $rekap,
            'tanggal' => $tanggal,
            'wisata' => $wisata,]
        );
    }
}
