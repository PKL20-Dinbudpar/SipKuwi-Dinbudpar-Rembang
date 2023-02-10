<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\KunjunganWisataExport;
use App\Models\RekapWisata;
use App\Models\Wisata;
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

        return view('livewire.dinas.edit-rekap', [
            'wisata' => $wisata,
            'rekap' => $rekap,
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
}
