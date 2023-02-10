<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\KunjunganHotelExport;
use App\Models\Hotel;
use App\Models\RekapHotel;
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

        $rekap = $rekap->paginate(10);

        return view('livewire.dinas.edit-rekap-hotel', [
            'hotel' => $hotel,
            'rekap' => $rekap,
        ]);
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
        $this->validate();

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
}
