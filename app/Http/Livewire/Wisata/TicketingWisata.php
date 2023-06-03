<?php

namespace App\Http\Livewire\Wisata;

use App\Models\Receipt;
use App\Models\RekapWisata;
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
        $this->validate([
            'tiketWisata.nama_tiket' => 'required',
            'tiketWisata.deskripsi' => '',
            'tiketWisata.harga' => 'required|int|min:0',
        ], [
            'tiketWisata.nama_tiket.required' => 'Nama tiket tidak boleh kosong',
            'tiketWisata.harga.required' => 'Harga tiket tidak boleh kosong',
            'tiketWisata.harga.min' => 'Harga tiket tidak boleh kurang dari 0',
        ]);

        if (isset($this->tiketWisata->id_tiket)) {
            $this->tiketWisata->save();
            session()->flash('message', 'Tiket berhasil diubah');
        }
        else {
            $this->tiketWisata->id_wisata = auth()->user()->id_wisata;
            $this->tiketWisata->save();
            session()->flash('message', 'Tiket berhasil ditambahkan');
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
            // 'kembalian' => 'numeric|min:0',
        ], [
            'jumlahTiket.*.required' => 'Jumlah tiket tidak boleh kosong',
            'jumlahTiket.*.min' => 'Jumlah tiket tidak boleh kurang dari 0',
            'uangMasuk.required' => 'Uang masuk tidak boleh kosong',
            'uangMasuk.min' => 'Uang masuk tidak boleh kurang dari 0',
            // 'kembalian.min' => 'Kembalian tidak boleh kurang dari 0',
        ]);

        $totalPendapatan = 0;
        foreach ($this->jumlahTiket as $ticketId => $jumlahTiket) {
            $totalPendapatan += $jumlahTiket * $this->hargaTiket[$ticketId];
        }

        $jumlahTiket = array_sum($this->jumlahTiket);

        // insert transaksi
        $transaksi = new Transaksi();
        $transaksi->waktu_transaksi = now();
        $transaksi->id_wisata = auth()->user()->id_wisata;
        $transaksi->id_user = auth()->user()->id;
        $transaksi->jenis_wisatawan = $this->jenisWisatawan;
        $transaksi->jumlah_tiket = $jumlahTiket;
        $transaksi->uang_masuk = $this->uangMasuk;
        $transaksi->kembalian = $this->kembalian;
        $transaksi->total_pendapatan = $totalPendapatan;

        $transaksi->save();

        // update rekap
        $rekap = RekapWisata::where('id_wisata', auth()->user()->id_wisata)
                ->where('tanggal', now()->format('Y-m-d'))        
                ->first();

        if ($rekap) {
            if ($this->jenisWisatawan == 'wisnus') {
                $rekap->wisatawan_nusantara += $jumlahTiket;
            }
            else if ($this->jenisWisatawan == 'wisman') {
                $rekap->wisatawan_mancanegara += $jumlahTiket;
            }

            $rekap->total_pendapatan += $this->uangMasuk - $this->kembalian;
            $rekap->save();
        }
        else {
            $newRekap = new RekapWisata();

            if ($this->jenisWisatawan == 'wisnus') {
                $newRekap->wisatawan_nusantara = $jumlahTiket;
            }
            else if ($this->jenisWisatawan == 'wisman') {
                $newRekap->wisatawan_mancanegara = $jumlahTiket;
            }

            $newRekap->tanggal = now()->format('Y-m-d');
            $newRekap->id_wisata = auth()->user()->id_wisata;
            $newRekap->total_pendapatan = $this->uangMasuk - $this->kembalian;
            $newRekap->save();
        }

        // insert to receipt
        foreach ($this->jumlahTiket as $ticketId => $jumlahTiket) {
            $receipt = new Receipt();
            $receipt->id_transaksi = $transaksi->id_transaksi;
            $receipt->id_tiket = $ticketId;
            $receipt->jumlah_tiket = $jumlahTiket;
            $receipt->total_pendapatan = $jumlahTiket * $this->hargaTiket[$ticketId];

            $receipt->save();
        }
        

        session()->flash('message', 'Order tiket berhasil disimpan.');

        $this->emit('transaksiSaved');
    }
}
