<?php

namespace App\Http\Livewire\Wisata;

use App\Models\RekapWisata;
use App\Models\Wisata;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class ChartKunjunganWisata extends Component
{
    public $wisata;
    public $tahun;
    public $showGraph;

    public $firstRun = true;

    public function mount()
    {
        $this->wisata = Wisata::where('id_wisata', auth()->user()->id_wisata)->first();
        $this->tahun = date('Y');
        $this->showGraph = true;
    }
    
    protected $listeners = [
        'onColumnClick' => 'handleOnColumnClick',
        'onPointClick' => 'handleOnPointClick',
    ];

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function handleOnPointClick($column)
    {
        dd($column);
    }

    public function updatedTahun()
    {
        // $this->showGraph = false;
    }

    public function showGraph()
    {
        $this->showGraph = !$this->showGraph;
    }

    public function render()
    {
        $rekap = RekapWisata::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_nusantara) wisatawan_nusantara, SUM(wisatawan_mancanegara) wisatawan_mancanegara')
                    ->where('id_wisata', auth()->user()->id_wisata)
                    ->whereYear('tanggal', $this->tahun)
                    ->groupBy('id_wisata', 'bulan', 'tahun')
                    ->get();

        $chartModel = $rekap
            ->reduce(function (ColumnChartModel $columnChartModel, $data) {
                $month = $data->bulan;
                if ($month == 1) {
                    $nama_bulan = 'Januari';
                } elseif ($month == 2) {
                    $nama_bulan = 'Februari';
                } elseif ($month == 3) {
                    $nama_bulan = 'Maret';
                } elseif ($month == 4) {
                    $nama_bulan = 'April';
                } elseif ($month == 5) {
                    $nama_bulan = 'Mei';
                } elseif ($month == 6) {
                    $nama_bulan = 'Juni';
                } elseif ($month == 7) {
                    $nama_bulan = 'Juli';
                } elseif ($month == 8) {
                    $nama_bulan = 'Agustus';
                } elseif ($month == 9) {
                    $nama_bulan = 'September';
                } elseif ($month == 10) {
                    $nama_bulan = 'Oktober';
                } elseif ($month == 11) {
                    $nama_bulan = 'November';
                } elseif ($month == 12) {
                    $nama_bulan = 'Desember';
                }
                $value = $data->wisatawan_nusantara + $data->wisatawan_mancanegara;
                $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $columnChartModel->addColumn($nama_bulan, $value, $warna[$data->first()->bulan]);
            }, LivewireCharts::columnChartModel()
                ->setTitle('Jumlah Wisatawan')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->withGrid()
            );

        $multiLineChartModel = $rekap
            ->reduce(function ($multiLineChartModel, $data) use ($rekap) {
                $month = $data->bulan;
                if ($month == 1) {
                    $nama_bulan = 'Januari';
                } elseif ($month == 2) {
                    $nama_bulan = 'Februari';
                } elseif ($month == 3) {
                    $nama_bulan = 'Maret';
                } elseif ($month == 4) {
                    $nama_bulan = 'April';
                } elseif ($month == 5) {
                    $nama_bulan = 'Mei';
                } elseif ($month == 6) {
                    $nama_bulan = 'Juni';
                } elseif ($month == 7) {
                    $nama_bulan = 'Juli';
                } elseif ($month == 8) {
                    $nama_bulan = 'Agustus';
                } elseif ($month == 9) {
                    $nama_bulan = 'September';
                } elseif ($month == 10) {
                    $nama_bulan = 'Oktober';
                } elseif ($month == 11) {
                    $nama_bulan = 'November';
                } elseif ($month == 12) {
                    $nama_bulan = 'Desember';
                }
                $value_nusantara = $data->wisatawan_nusantara;
                $value_mancanegara = $data->wisatawan_mancanegara;
                $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $multiLineChartModel->addSeriesPoint('Wisatawan Nusantara', $nama_bulan, $value_nusantara, $warna[$data->first()->bulan])
                    ->addSeriesPoint('Wisatawan Mancanegara', $nama_bulan, $value_mancanegara, $warna[$data->first()->bulan]);

            }, LivewireCharts::multiLineChartModel()
                ->setTitle('Jumlah Wisatawan')
                ->setAnimated($this->firstRun)
                ->withOnPointClickEvent('onPointClick')
                ->multiLine()
            );

        return view('livewire.wisata.chart-kunjungan-wisata', [
            'chartModel' => $chartModel,
            'multiLineChartModel' => $multiLineChartModel,
        ]);
    }
}
