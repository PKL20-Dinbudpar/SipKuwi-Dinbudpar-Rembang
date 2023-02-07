<?php

namespace App\Http\Livewire;

use App\Models\Rekap;
use App\Models\Tiket;
use App\Models\Transaksi;
use Livewire\Component;

class TicketingWisata extends Component
{
    public $tiketWisata;

    public $tiket;
    public $jumlahTiket;
    public $hargaTiket;

    public $jenisWisatawan;
    public $uangMasuk;
    public $kembalian;

    protected $rules = [
        'tiketWisata.nama_tiket' => 'required',
        'tiketWisata.deskripsi' => '',
        'tiketWisata.harga' => 'required|int',
    ];

    public function mount()
    {
        $this->tiketWisata = new Tiket();

        $this->tiket = Tiket::where('id_wisata', auth()->user()->id_wisata)->get();
        $this->jumlahTiket = [];
        $this->hargaTiket = [];

        foreach ($this->tiket as $t) {
            $this->jumlahTiket[$t->id_tiket] = 0;
            $this->hargaTiket[$t->id_tiket] = $t->harga;
        }

        $this->jenisWisatawan = 'wisnus';
    }

    public function render()
    {
        $tikets = Tiket::where('id_wisata', auth()->user()->id_wisata)->get();

        return view('livewire.wisata.ticketing-wisata', [
            'tikets' => $tikets,
            'tiket' => $this->tiket,
            'jumlahTiket' => $this->jumlahTiket,
            'hargaTiket' => $this->hargaTiket,
        ]);
    }

    public function resetInput()
    {
        $this->tiketWisata = new Tiket();
        $this->resetErrorBag();
    }

    public function refreshTiket()
    {
        $this->tiket = Tiket::where('id_wisata', auth()->user()->id_wisata)->get();

        $this->jumlahTiket = [];
        $this->hargaTiket = [];
        
        foreach ($this->tiket as $t) {
            $this->jumlahTiket[$t->id_tiket] = 0;
            $this->hargaTiket[$t->id_tiket] = $t->harga;
        }
    }

    public function editTiket(Tiket $tiket)
    {
        $this->resetErrorBag();
        $this->tiketWisata = $tiket;
    }

    public function saveTiket()
    {
        $this->validate();

        if (isset($this->tiketWisata->id_tiket)) {
            $this->tiketWisata->save();
            session()->flash('message', 'Data rekap berhasil diubah');
        }
        else {
            $this->tiketWisata->id_wisata = auth()->user()->id_wisata;
            $this->tiketWisata->save();
            session()->flash('message', 'Data rekap berhasil ditambahkan');
        }

        $this->refreshTiket();
        $this->resetInput();
        $this->emit('tiketSaved');
    }

    public function deleteTiket(Tiket $tiket)
    {
        $this->tiketWisata = $tiket;
    }

    public function destroyTiket()
    {
        Tiket::destroy($this->tiketWisata->id_tiket);
        session()->flash('message', 'Tiket berhasil dihapus');

        $this->refreshTiket();
        $this->resetInput();

        $this->emit('tiketDeleted');
    }

    // fungsi transaksi
    public function resetInputTransaksi()
    {
        $this->refreshTiket();

        $this->jenisWisatawan = 'wisnus';
        $this->uangMasuk = '';
        $this->kembalian = '';

        $this->resetErrorBag();
    }

    
    public function updatedUangMasuk()
    {
        $this->validate([
            'uangMasuk' => 'required|numeric|min:0',
        ]);

        $totalPendapatan = 0;
        foreach ($this->jumlahTiket as $ticketId => $jumlahTiket) {
            $totalPendapatan += $jumlahTiket * $this->hargaTiket[$ticketId];
        }

        $this->kembalian = $this->uangMasuk - $totalPendapatan;
    }

    public function submitTransaksi()
    {
        $this->validate([
            'jumlahTiket.*' => 'required|numeric|min:0',
            'uangMasuk' => 'required|numeric|min:0',
        ]);

        $totalPendapatan = 0;
        foreach ($this->jumlahTiket as $ticketId => $jumlahTiket) {
            $totalPendapatan += $jumlahTiket * $this->hargaTiket[$ticketId];
        }

        $jumlahTiket = array_sum($this->jumlahTiket);

        Transaksi::create([
            'waktu_transaksi' => now(),
            'id_wisata' => auth()->user()->id_wisata,
            'id_user' => auth()->user()->id,
            'jenis_wisatawan' => $this->jenisWisatawan,
            'jumlah_tiket' => $jumlahTiket,
            'total_pendapatan' => $this->uangMasuk - $this->kembalian,
        ]);

        $rekap = Rekap::where('id_wisata', auth()->user()->id_wisata)
                ->where('tanggal', now()->format('Y-m-d'))        
                ->first();

        if ($rekap) {
            if ($this->jenisWisatawan == 'wisnus') {
                $rekap->wisatawan_domestik += $jumlahTiket;
            }
            else if ($this->jenisWisatawan == 'wisman') {
                $rekap->wisatawan_mancanegara += $jumlahTiket;
            }

            $rekap->total_pendapatan += $this->uangMasuk - $this->kembalian;
            $rekap->save();
        }
        else {
            Rekap::create([
                'tanggal' => now()->format('Y-m-d'),
                'id_wisata' => auth()->user()->id_wisata,
                'wisatawan_domestik' => $jumlahTiket,
            ]);
        }

        session()->flash('message', 'Order tiket berhasil disimpan.');

        $this->emit('transaksiSaved');
    }

    // public function updatedKembalian()
    // {
    //     $this->validate([
    //         'kembalian' => 'required|numeric|min:0',
    //     ]);

    //     $totalPendapatan = 0;
    //     foreach ($this->jumlahTiket as $ticketId => $jumlahTiket) {
    //         $totalPendapatan += $jumlahTiket * $this->hargaTiket[$ticketId];
    //     }

    //     $this->uangMasuk = $this->kembalian + $totalPendapatan;
    // }
}
