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

    public function mount()
    {
        $this->hotel = Hotel::where('id_hotel', auth()->user()->id_hotel)->first();
        $this->tahun = date('Y');
        $this->showGraph = true;
    }
    
    protected $listeners = [
        'onColumnClick' => 'handleOnColumnClick',
    ];

    public function handleOnColumnClick($column)
    {
        dd($column);
    }

    public function updatedTahun()
    {
        $this->showGraph = false;
    }

    public function showGraph()
    {
        $this->showGraph = !$this->showGraph;
    }

    public function render()
    {
        $year = [$this->tahun];

        $rekap = RekapHotel::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(pengunjung_nusantara) pengunjung_nusantara, SUM(pengunjung_mancanegara) pengunjung_mancanegara')
                    ->where('id_hotel', auth()->user()->id_hotel)
                    ->whereYear('tanggal', $year)
                    ->groupBy('id_hotel', 'bulan', 'tahun')
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
                $value = $data->pengunjung_nusantara + $data->pengunjung_mancanegara;
                $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));

                return $columnChartModel->addColumn($nama_bulan, $value, $warna[$data->first()->bulan]);
            }, LivewireCharts::columnChartModel()
                ->setTitle('Jumlah Pengunjung')
                ->setAnimated($this->firstRun)
                ->withOnColumnClickEventName('onColumnClick')
                ->withGrid()
            );

        return view('livewire.hotel.chart-kunjungan-hotel', [
            'chartModel' => $chartModel,
        ]);
    }
}
