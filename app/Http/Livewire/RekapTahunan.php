<?php

namespace App\Http\Livewire;

use App\Exports\RekapBulananExport;
use App\Exports\RekapTahunanExport;
use App\Models\Rekap;
use App\Models\Wisata;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class RekapTahunan extends Component
{
    public $tahun;
    public $totalWisatawan;
    public $totalPendapatan;

    // public $firstRun = true;
    
    public function mount()
    {
        $this->tahun = date('Y');
    }
    
    // protected $listeners = [
    //     'onColumnClick' => 'handleOnColumnClick',
    //     'refreshComponent' => '$refresh'
    // ];

    // public function handleOnColumnClick($column)
    // {
    //     // dd($column);
    //     dd($this->tahun);
    // }

    public function render()
    {
        $bulan = Rekap::selectRaw('MONTH(tanggal) bulan, YEAR(tanggal) tahun')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('bulan', 'tahun')
                ->get();

        $rekap = Rekap::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_domestik) wisatawan_domestik, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                ->whereYear('tanggal', '=', $this->tahun)
                ->groupBy('id_wisata', 'bulan', 'tahun')
                ->get();

        $wisata = Wisata::all();

        foreach ($wisata as $key => $value) {
            $wisata_id[] = $value->id_wisata;
        }
        
        // $total = Rekap::whereYear('tanggal', '=', $this->tahun)
        //         ->whereIn('id_wisata', $wisata_id)
        //         ->get();
        
        // $columnChartModel = $total->groupBy('id_wisata')
        //     ->reduce(function (ColumnChartModel $columnChartModel, $data) {
        //         $wisata_name = $data->first()->wisata->nama_wisata;
        //         $value = $data->sum('wisatawan_domestik') + $data->sum('wisatawan_mancanegara');
        //         $warna[$data->first()->wisata->nama_wisata] = '#'.dechex(rand(0x000000, 0xFFFFFF));

        //         return $columnChartModel->addColumn($wisata_name, $value, $warna[$wisata_name]);
        //     }, LivewireCharts::columnChartModel()
        //         ->setTitle('Jumlah Pengunjung Tahunan')
        //         ->setAnimated($this->firstRun)
        //         ->withOnColumnClickEventName('onColumnClick')
        //         ->withGrid()
        //     );

        // $this->firstRun = false;
                
        return view('livewire.dinas.rekap-tahunan', [
            // 'columnChartModel' => $columnChartModel,
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
