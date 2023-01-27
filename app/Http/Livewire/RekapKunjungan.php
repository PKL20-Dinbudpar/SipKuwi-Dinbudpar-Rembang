<?php

namespace App\Http\Livewire;

use App\Models\Rekap;
use Livewire\Component;
use Livewire\WithPagination;

class RekapKunjungan extends Component
{
    use WithPagination;
    public $dataRekap;
    
    public $tahun;
    public $bulan;
    public $tanggal;

    protected $rules = [
        'dataRekap.wisatawan_domestik' => 'required|int',
        'dataRekap.wisatawan_mancanegara' => 'required|int',
        'dataRekap.total_pendapatan' => 'required|int',
    ];

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

        // dd($rekap);
        
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

        $this->dataRekap->save();
        session()->flash('message', 'Objek wisata berhasil diubah');

        $this->resetInput();
        $this->emit('rekapSaved');
    }

    public function resetInput()
    {
        $this->reset(['dataRekap']);
        $this->resetErrorBag();
    }
}
