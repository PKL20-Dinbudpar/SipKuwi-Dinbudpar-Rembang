<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Transaksi;
use Livewire\WithPagination;

class DaftarTransaksi extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $tanggal;
    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->tanggal = date('d');
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function render()
    {
        $transaksi = Transaksi::with('user')
                    ->where('id_wisata', auth()->user()->id_wisata)
                    ->whereDay('waktu_transaksi', $this->tanggal)
                    ->whereMonth('waktu_transaksi', $this->bulan)
                    ->whereYear('waktu_transaksi', $this->tahun)
                    ->orderBy('waktu_transaksi', 'desc');
                    
        $transaksi = $transaksi->paginate(10);

        return view('livewire.wisata.daftar-transaksi', [
            'transaksi' => $transaksi
        ]);
    }
}

