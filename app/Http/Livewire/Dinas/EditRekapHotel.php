<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\KunjunganHotelExport;
use App\Models\Hotel;
use App\Models\RekapHotel;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class EditRekapHotel extends Component
{
    public $idHotel;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dataRekap;
    public $deleteRekap;
    
    public $tahun;
    public $bulan;
    public $tanggal;

    // chart
    public $showGraph;
    public $tahunChart;
    public $firstRun = true;

    protected $rules = [
        'dataRekap.tanggal' => 'required',
        'dataRekap.pengunjung_nusantara' => 'required|int',
        'dataRekap.pengunjung_mancanegara' => 'required|int',
        'dataRekap.kamar_terjual' => 'required|int',
    ];

    public function mount($idHotel = null)
    {
        $this->idHotel = $idHotel;
        $this->dataRekap = new RekapHotel();

        $this->tahunChart = date('Y');
        $this->showGraph = true;
    }

    public function render()
    {
        $hotel = Hotel::findOrFail($this->idHotel);
                    
        $rekap = RekapHotel::where('id_hotel', $this->idHotel)
                    ->when($this->tahun, function($query){
                        return $query->whereYear('tanggal', '=', $this->tahun);
                    })
                    ->when($this->bulan, function($query){
                        $query->whereMonth('tanggal', '=', $this->bulan);
                    })
                    ->when($this->tanggal, function($query){
                        $query->whereDay('tanggal', '=', $this->tanggal);
                    })
                    ->orderBy('tanggal', 'desc');

        // $ =

        $rekap = $rekap->paginate(10);

        $dataRekap = RekapHotel::selectRaw('id_hotel, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(pengunjung_nusantara) pengunjung_nusantara, SUM(pengunjung_mancanegara) pengunjung_mancanegara, SUM(kamar_terjual) kamar_terjual')
                    ->where('id_hotel', $this->idHotel)
                    ->whereYear('tanggal', $this->tahunChart)
                    ->groupBy('id_hotel', 'bulan', 'tahun')
                    ->get();

        $kunjunganChart = $dataRekap
                    ->reduce(function ($multiLineChartModel, $data) {
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

        // $kamarChart = $dataRekap
        //             ->reduce(function ($columnChartModel, $data) {
        //                 $month = $data->bulan;
        //                 if ($month == 1) {
        //                     $nama_bulan = 'Januari';
        //                 } elseif ($month == 2) {
        //                     $nama_bulan = 'Februari';
        //                 } elseif ($month == 3) {
        //                     $nama_bulan = 'Maret';
        //                 } elseif ($month == 4) {
        //                     $nama_bulan = 'April';
        //                 } elseif ($month == 5) {
        //                     $nama_bulan = 'Mei';
        //                 } elseif ($month == 6) {
        //                     $nama_bulan = 'Juni';
        //                 } elseif ($month == 7) {
        //                     $nama_bulan = 'Juli';
        //                 } elseif ($month == 8) {
        //                     $nama_bulan = 'Agustus';
        //                 } elseif ($month == 9) {
        //                     $nama_bulan = 'September';
        //                 } elseif ($month == 10) {
        //                     $nama_bulan = 'Oktober';
        //                 } elseif ($month == 11) {
        //                     $nama_bulan = 'November';
        //                 } elseif ($month == 12) {
        //                     $nama_bulan = 'Desember';
        //                 }
        //                 $value = $data->kamar_terjual;
        //                 $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));
        
        //                 return $columnChartModel->addColumn($nama_bulan, $value, $warna[$data->first()->bulan]);
        //             }, LivewireCharts::columnChartModel()
        //                 ->setTitle('Kamar Terjual')
        //                 ->setAnimated($this->firstRun)
        //                 ->withOnColumnClickEventName('onColumnClick')
        //                 ->withGrid()
        //             );

        // line chart kamar terjual
        $kamarChart = $dataRekap
                    ->reduce(function ($lineChartModel, $data) {
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
        
                        return $lineChartModel->addPoint($nama_bulan, $value, $warna[$data->first()->bulan]);
                    }, LivewireCharts::lineChartModel()
                        ->setTitle('Kamar Terjual')
                        ->setAnimated($this->firstRun)
                        ->withOnPointClickEvent('onPointClick')
                        ->setSmoothCurve()
                        ->withGrid()
                    );

        return view('livewire.dinas.edit-rekap-hotel', [
            'hotel' => $hotel,
            'rekap' => $rekap,
            'kunjunganChart' => $kunjunganChart,
            'kamarChart' => $kamarChart,
        ]);
    }

    public function updatedTahunChart()
    {
        // $this->showGraph = false;
    }

    public function editRekap(RekapHotel $rekap)
    {
        $this->resetErrorBag();
        $this->dataRekap = $rekap;

        // Set date time to Asia Jakarta
        $dateTime = new \DateTime($this->dataRekap->tanggal);
        $dateTime->setTime(7, 0, 0);
        $this->dataRekap->tanggal = $dateTime->format('Y-m-d\TH:i:s');
    }
    
    public function saveRekap()
    {
        // $this->validate();
        // validate with custom error message
        $this->validate([
            'dataRekap.tanggal' => 'required',
            'dataRekap.pengunjung_nusantara' => 'required|int|gte:0',
            'dataRekap.pengunjung_mancanegara' => 'required|int|gte:0',
            'dataRekap.kamar_terjual' => 'required|int|gte:0',
        ], [
            'dataRekap.tanggal.required' => 'Tanggal tidak boleh kosong',
            'dataRekap.pengunjung_nusantara.required' => 'Pengunjung nusantara tidak boleh kosong',
            'dataRekap.pengunjung_nusantara.gte' => 'Pengunjung nusantara tidak boleh kurang dari 0',
            'dataRekap.pengunjung_mancanegara.required' => 'Pengunjung mancanegara tidak boleh kosong',
            'dataRekap.pengunjung_mancanegara.gte' => 'Pengunjung mancanegara tidak boleh kurang dari 0',
            'dataRekap.kamar_terjual.required' => 'Kamar terjual tidak boleh kosong',
            'dataRekap.kamar_terjual.gte' => 'Kamar terjual tidak boleh kurang dari 0',
        ]);

        $this->dataRekap->id_user = auth()->user()->id;
        $this->dataRekap->updated_at = now();

        if (isset($this->dataRekap->id_rekap)) {
            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil diubah');
        }
        else {
            $this->dataRekap->id_hotel = $this->idHotel;
            // make datetime to Asia Jakarta
            $dateTime = new \DateTime($this->dataRekap->tanggal);
            $dateTime->setTime(7, 0, 0);

            // Exception for non duplicate date in same hotel
            $rekap = RekapHotel::where('id_hotel', $this->idHotel)
                        ->where('tanggal', $dateTime->format('Y-m-d'))
                        ->first();
            if ($rekap) {
                $this->tanggal = $dateTime->format('d');
                $this->bulan = $dateTime->format('m');
                $this->tahun = $dateTime->format('Y');
                
                session()->flash('message', 'Data rekap sudah ada');
                $this->emit('rekapSaved');
                return;
            }

            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil ditambahkan');
        }
        
        $this->resetInput();
        $this->emit('rekapSaved');
    }

    public function resetInput()
    {
        $this->dataRekap = new RekapHotel();
        $this->resetErrorBag();
    }

    public function deleteRekap(RekapHotel $rekap)
    {
        $this->deleteRekap = $rekap;
    }

    public function destroyRekap()
    {
        RekapHotel::destroy($this->deleteRekap->id_rekap);
        session()->flash('message', 'Rekap data berhasil dihapus');

        $this->reset(['deleteRekap']);
        $this->resetInput();
        $this->emit('rekapDeleted');
    }

    public function export(){
        $hotel = Hotel::findOrFail($this->idHotel);

        return Excel::download(new KunjunganHotelExport($this->idHotel), 'Rekap_Kunjungan_' . $hotel->nama_hotel . '.xlsx');
    }

    // chart func
    public function showGraph()
    {
        $this->showGraph = !$this->showGraph;
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
}
