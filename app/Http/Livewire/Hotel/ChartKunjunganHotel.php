<?php

namespace App\Http\Livewire\Hotel;

use App\Models\Hotel;
use App\Models\RekapHotel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class ChartKunjunganHotel extends Component
{
    public $hotel;
    public $tahun;
    public $showGraph;

    public $firstRun = true;
    public $showDataLabels = false;

    public function mount()
    {
        $this->hotel = Hotel::where('id_hotel', auth()->user()->id_hotel)->first();
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
        $rekap = RekapHotel::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(pengunjung_nusantara) pengunjung_nusantara, SUM(pengunjung_mancanegara) pengunjung_mancanegara, SUM(kamar_terjual) kamar_terjual')
                    ->where('id_hotel', auth()->user()->id_hotel)
                    ->whereYear('tanggal', $this->tahun)
                    ->groupBy('id_hotel', 'bulan', 'tahun')
                    ->get();

        $columnChartModel = $rekap
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
                $value = $data->kamar_terjual;
                $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $columnChartModel->addColumn($nama_bulan, $value, $warna[$data->first()->bulan]);
            }, LivewireCharts::columnChartModel()
                ->setTitle('Jumlah Pengunjung')
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
                $value_nusantara = $data->pengunjung_nusantara;
                $value_mancanegara = $data->pengunjung_mancanegara;
                $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $multiLineChartModel->addSeriesPoint('Pengunjung Nusantara', $nama_bulan, $value_nusantara, $warna[$data->first()->bulan])
                    ->addSeriesPoint('Pengunjung Mancanegara', $nama_bulan, $value_mancanegara, $warna[$data->first()->bulan]);

            }, LivewireCharts::multiLineChartModel()
                ->setTitle('Jumlah Pengunjung')
                ->setAnimated($this->firstRun)
                ->withOnPointClickEvent('onPointClick')
                ->multiLine()
            );

        return view('livewire.hotel.chart-kunjungan-hotel', [
            'columnChartModel' => $columnChartModel,
            'multiLineChartModel' => $multiLineChartModel,
        ]);
    }
}
