<?php

namespace App\Http\Livewire;

use App\Exports\RekapBulananExport;
use App\Models\Rekap;
use App\Models\Wisata;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapBulanan extends Component
{
    public $bulan;
    public $tahun;
    public $totalWisatawan;
    public $totalPendapatan;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $tanggal = Rekap::with('wisata')
                ->join('wisata', 'rekap.id_wisata', '=', 'wisata.id_wisata')
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


        return view('livewire.dinas.rekap-bulanan', [
            'tanggal' => $tanggal,
            'rekap' => $rekap,
            'wisata' => $wisata,
        ]);
    }

    public function export()
    {
        // return Excel::download(new RekapKunjungan, 'RekapBulanan.xlsx');
        return Excel::download(new RekapBulananExport($this->bulan, $this->tahun), 'RekapBulanan.xlsx');
    }
}
