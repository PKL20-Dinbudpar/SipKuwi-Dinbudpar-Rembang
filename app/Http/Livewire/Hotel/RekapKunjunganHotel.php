<?php

namespace App\Http\Livewire\Hotel;

use App\Exports\KunjunganHotelExport;
use App\Models\Hotel;
use App\Models\RekapHotel;
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
        'dataRekap.pengunjung_nusantara' => 'required|int',
        'dataRekap.pengunjung_mancanegara' => 'required|int',
        'dataRekap.kamar_terjual' => 'required|int',
    ];

    public function mount()
    {
        $this->dataRekap = new RekapHotel();
    }

    public function render()
    {
        $todayRekap = RekapHotel::where('id_hotel', auth()->user()->id_hotel)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();

        $rekap = RekapHotel::where('id_hotel', auth()->user()->id_hotel)
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

    public function editRekap(RekapHotel $rekap)
    {
        $this->resetErrorBag();
        $this->dataRekap = $rekap;

        // Set date time to Asia Jakarta
        $dateTime = new \DateTime($this->dataRekap->tanggal);
        $dateTime->setTime(7, 0, 0);
        $this->dataRekap->tanggal = $dateTime->format('Y-m-d\TH:i:s');
    }

    public function editTodayRekap()
    {
        $this->resetErrorBag();
        $this->dataRekap = new RekapHotel();
        $this->dataRekap->tanggal = date('Y-m-d\TH:i:s');

        // Set date time to Asia Jakarta
        $dateTime = new \DateTime();
        $dateTime->setTime(7, 0, 0);
        $this->dataRekap->tanggal = $dateTime->format('Y-m-d\TH:i:s');
    }
    
    public function saveRekap()
    {
        $this->validate([
            'dataRekap.tanggal' => 'required',
            'dataRekap.pengunjung_nusantara' => 'required|int|gte:0',
            'dataRekap.pengunjung_mancanegara' => 'required|int|gte:0',
            'dataRekap.kamar_terjual' => 'required|int|gte:0'
        ], [
            'dataRekap.tanggal.required' => 'Tanggal tidak boleh kosong',
            'dataRekap.pengunjung_nusantara.required' => 'Jumlah pengunjung nusantara tidak boleh kosong',
            'dataRekap.pengunjung_nusantara.gte' => 'Pengunjung nusantara tidak boleh kurang dari 0',
            'dataRekap.pengunjung_mancanegara.required' => 'Jumlah pengunjung mancanegara tidak boleh kosong',
            'dataRekap.pengunjung_mancanegara.gte' => 'Pengunjung mancanegara tidak boleh kurang dari 0',
            'dataRekap.kamar_terjual.required' => 'Jumlah kamar terjual tidak boleh kosong',
            'dataRekap.kamar_terjual.gte' => 'Kamar terjual tidak boleh kurang dari 0',
        ]);

        if (isset($this->dataRekap->id_rekap)) {
            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil diubah');
        }
        else {
            $this->dataRekap->id_hotel = auth()->user()->id_hotel;
            // make datetime to Asia Jakarta
            $dateTime = new \DateTime($this->dataRekap->tanggal);
            $dateTime->setTime(7, 0, 0);

            // Exception for non duplicate date in same hotel
            $rekap = RekapHotel::where('id_hotel', auth()->user()->id_hotel)
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
        $hotel = Hotel::where('id_hotel', auth()->user()->id_hotel)->first();

        return Excel::download(new KunjunganHotelExport(), 'Rekap_Kunjungan_' . $hotel->nama_hotel . '.xlsx');
    }
}
