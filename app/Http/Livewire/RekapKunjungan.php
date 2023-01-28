<?php

namespace App\Http\Livewire;

use App\Models\Rekap;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class RekapKunjungan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $idWisata;
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

    public function mount()
    {
        $this->dataRekap = new Rekap();
    }

    public function render()
    {
        $todayRekap = Rekap::where('id_wisata', auth()->user()->id_wisata)
                    ->where('tanggal', date('Y-m-d'))
                    ->first();

        $rekap = Rekap::where('id_wisata', auth()->user()->id_wisata)
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

        return view('livewire.wisata.rekap-kunjungan', [
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
            $this->dataRekap->id_wisata = auth()->user()->id_wisata;
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
