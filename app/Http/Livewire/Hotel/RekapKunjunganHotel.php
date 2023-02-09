<?php

namespace App\Http\Livewire\Hotel;

use App\Exports\KunjunganHotelExport;
use App\Models\Hotel;
use App\Models\Rekap;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class RekapKunjunganHotel extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dataRekap;
    public $deleteRekap;
    
    public $tahun;
    public $bulan;
    public $tanggal;

    protected $rules = [
        'dataRekap.tanggal' => 'required',
        'dataRekap.wisatawan_nusantara' => 'required|int',
        'dataRekap.wisatawan_mancanegara' => 'required|int',
        'dataRekap.total_pendapatan' => 'required|int',
    ];

    public function mount()
    {
        $this->dataRekap = new Rekap();
    }

    public function render()
    {
        $todayRekap = Rekap::where('id_hotel', auth()->user()->id_hotel)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();

        $rekap = Rekap::where('id_hotel', auth()->user()->id_hotel)
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

        return view('livewire.hotel.rekap-kunjungan-hotel', [
            'todayRekap' => $todayRekap,
            'rekap' => $rekap,
        ]);
    }

    public function editRekap(Rekap $rekap)
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
            $this->dataRekap->id_hotel = auth()->user()->id_hotel;
            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil ditambahkan');
        }

        $this->resetInput();
        $this->emit('rekapSaved');
    }

    public function resetInput()
    {
        $this->dataRekap = new Rekap();
        $this->resetErrorBag();
    }

    public function deleteRekap(Rekap $rekap)
    {
        $this->deleteRekap = $rekap;
    }

    public function destroyRekap()
    {
        Rekap::destroy($this->deleteRekap->id_rekap);
        session()->flash('message', 'Rekap data berhasil dihapus');

        $this->reset(['deleteRekap']);
        $this->resetInput();
        $this->emit('rekapDeleted');
    }

    public function export(){
        $hotel = Hotel::where('id_hotel', auth()->user()->id_hotel)->first();

        return Excel::download(new KunjunganHotelExport(), 'Rekap_Kunjungan_' . $hotel->nama_hotel . '.xlsx');
    }
}
