<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\KunjunganWisataExport;
use App\Models\RekapWisata;
use App\Models\Wisata;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class EditRekap extends Component
{
    public $idWisata;

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
        'dataRekap.wisatawan_nusantara' => 'required|int',
        'dataRekap.wisatawan_mancanegara' => 'required|int',
        'dataRekap.total_pendapatan' => 'required|int',
    ];

    public function mount($idWisata = null)
    {
        $this->idWisata = $idWisata;
        $this->dataRekap = new RekapWisata();

        $this->tahunChart = date('Y');
        $this->showGraph = true;
    }

    public function render()
    {
        $wisata = Wisata::findOrFail($this->idWisata);
                    
        $rekap = RekapWisata::where('id_wisata', $this->idWisata)
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

        $rekap = $rekap->paginate(10);

        $dataRekap = RekapWisata::selectRaw('id_wisata, MONTH(tanggal) bulan, YEAR(tanggal) tahun, SUM(wisatawan_nusantara) wisatawan_nusantara, SUM(wisatawan_mancanegara) wisatawan_mancanegara, SUM(total_pendapatan) total_pendapatan')
                    ->where('id_wisata', $this->idWisata)
                    ->whereYear('tanggal', $this->tahunChart)
                    ->groupBy('id_wisata', 'bulan', 'tahun')
                    ->get();

        $wisatawanChart = $dataRekap
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

        $pendapatanChart = $dataRekap
                    ->reduce(function ($columnChartModel, $data) {
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
                        $value = $data->total_pendapatan;
                        $warna[$data->first()->bulan] = '#'.dechex(rand(0x000000, 0xFFFFFF));
        
                        return $columnChartModel->addColumn($nama_bulan, $value, $warna[$data->first()->bulan]);
                    }, LivewireCharts::columnChartModel()
                        ->setTitle('Pendapatan')
                        ->setAnimated($this->firstRun)
                        ->withOnColumnClickEventName('onColumnClick')
                        ->withGrid()
                    );
                    
    return view('livewire.dinas.edit-rekap', [
            'wisata' => $wisata,
            'rekap' => $rekap,
            'wisatawanChart' => $wisatawanChart,
            'pendapatanChart' => $pendapatanChart,
        ]);
    }

    public function editRekap(RekapWisata $rekap)
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
        $this->validate();

        if (isset($this->dataRekap->id_rekap)) {
            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil diubah');
        }
        else {
            $this->dataRekap->id_wisata = $this->idWisata;
            // make datetime to Asia Jakarta
            $dateTime = new \DateTime($this->dataRekap->tanggal);
            $dateTime->setTime(7, 0, 0);

            // Exception for non duplicate date in same hotel
            $rekap = RekapWisata::where('id_wisata', $this->idWisata)
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
        $this->dataRekap = new RekapWisata();
        $this->resetErrorBag();
    }

    public function deleteRekap(RekapWisata $rekap)
    {
        $this->deleteRekap = $rekap;
    }

    public function destroyRekap()
    {
        RekapWisata::destroy($this->deleteRekap->id_rekap);
        session()->flash('message', 'Rekap data berhasil dihapus');

        $this->reset(['deleteRekap']);
        $this->resetInput();
        $this->emit('rekapDeleted');
    }

    public function export()
    {
        $wisata = Wisata::findOrFail($this->idWisata);

        return Excel::download(new KunjunganWisataExport($this->idWisata), 'Rekap_' . $wisata->nama_wisata . '.xlsx');
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
