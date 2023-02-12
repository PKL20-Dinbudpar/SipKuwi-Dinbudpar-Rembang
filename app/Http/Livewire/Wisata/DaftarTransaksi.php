<?php

namespace App\Http\Livewire\Wisata;

use App\Models\Receipt;
use App\Models\RekapWisata;
use App\Models\Tiket;
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

    public $tiket;
    public $namaTiket;
    public $jumlahTiket;
    public $hargaTiket;

    public $dataTransaksi;

    public function mount()
    {
        $this->tanggal = date('d');
        $this->bulan = date('m');
        $this->tahun = date('Y');

        $this->tiket = [];
        $this->jumlahTiket = [];
        $this->hargaTiket = [];

        foreach ($this->tiket as $t) {
            $this->jumlahTiket[$t->id_tiket] = 0;
            $this->hargaTiket[$t->id_tiket] = $t->harga;
        }

        $this->dataTransaksi = new Transaksi();
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

    public function viewTransaksi($idTransaksi)
    {
        $receipt = Receipt::where('id_transaksi', $idTransaksi)->get();

        $this->tiket = Tiket::where('id_wisata', auth()->user()->id_wisata)->get();
        $this->jumlahTiket = [];
        $this->hargaTiket = [];

        foreach ($this->tiket as $t) {
            if ($receipt)
                $this->jumlahTiket[$t->id_tiket] = $receipt->where('id_tiket', $t->id_tiket)->first()->jumlah_tiket;
            else
                $this->jumlahTiket[$t->id_tiket] = 0;

            $this->hargaTiket[$t->id_tiket] = $t->harga;
        }
        
        $this->dataTransaksi = Transaksi::find($idTransaksi);
    }

    public function deleteTransaksi(Transaksi $transaksi)
    {
        $this->dataTransaksi = $transaksi;
    }

    public function destroyTransaksi()
    {
        $rekap = RekapWisata::where('id_wisata', $this->dataTransaksi->id_wisata)
                ->where('tanggal', date('Y-m-d', strtotime($this->dataTransaksi->waktu_transaksi)))
                ->first();
        // dd($rekap);
        if ($rekap) {
            if ($this->dataTransaksi->jenis_wisatawan == 'wisnus')
                $rekap->wisatawan_nusantara = $rekap->wisatawan_nusantara - $this->dataTransaksi->jumlah_tiket;
            else if ($this->dataTransaksi->jenis_wisatawan == 'wisman')
                $rekap->wisatawan_mancanegara = $rekap->wisatawan_mancanegara - $this->dataTransaksi->jumlah_tiket;
            
            $rekap->total_pendapatan = $rekap->total_pendapatan - $this->dataTransaksi->total_pendapatan;
            $rekap->save();
        }

        Transaksi::destroy($this->dataTransaksi->id_transaksi);
        $this->dataTransaksi = null;

        session()->flash('message', 'Transaksi berhasil dihapus');
        $this->emit('transaksiDeleted');
    }
}

