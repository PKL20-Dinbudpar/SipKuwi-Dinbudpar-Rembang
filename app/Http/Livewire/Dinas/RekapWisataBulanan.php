<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\WisataBulananExport;
use App\Models\RekapWisata;
use App\Models\Wisata;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapWisataBulanan extends Component
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
        $bulan = RekapWisata::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->join('wisata', 'rekap_wisata.id_wisata', '=', 'wisata.id_wisata')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = RekapWisata::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_nusantara) wisatawan_nusantara, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_wisata', 'bulan', 'tahun')
                ->get();

        $wisata = Wisata::all();
                
        return view('livewire.dinas.rekap-wisata-bulanan', [
            'rekap' => $rekap,
            'bulan' => $bulan,
            'wisata' => $wisata,
        ]);
    }

    public function export()
    {
        return Excel::download(new WisataBulananExport($this->tahun), 'RekapWisataBulanan'. $this->tahun .'.xlsx');
    }
}
