<?php

namespace App\Http\Livewire;

use App\Models\Rekap;
use App\Models\Wisata;
use Livewire\Component;
use Livewire\WithPagination;

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
        'dataRekap.wisatawan_domestik' => 'required|int',
        'dataRekap.wisatawan_mancanegara' => 'required|int',
        'dataRekap.total_pendapatan' => 'required|int',
    ];

    public function mount($idWisata = null)
    {
        $this->idWisata = $idWisata;
        $this->dataRekap = new Rekap();
    }

    public function render()
    {
        $wisata = Wisata::findOrFail($this->idWisata);

        $todayRekap = Rekap::where('id_wisata', $this->idWisata)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();
                    
        $rekap = Rekap::where('id_wisata', $this->idWisata)
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
            'todayRekap' => $todayRekap,
            'rekap' => $rekap,
        ]);
    }

    public function editRekap(Rekap $rekap)
    {
        $this->resetErrorBag();
        $this->dataRekap = $rekap;
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
            $this->dataRekap->save();
            session()->flash('message', 'Data rekap berhasil ditambahkan');
        }

        $this->dataRekap = new Rekap();
        $this->resetErrorBag();
        $this->emit('rekapSaved');
    }

    public function resetInput()
    {
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
}
