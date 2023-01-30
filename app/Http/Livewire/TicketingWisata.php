<?php

namespace App\Http\Livewire;

use App\Models\Tiket;
use Livewire\Component;

class TicketingWisata extends Component
{
    public $tiketWisata;

    protected $rules = [
        'tiketWisata.nama_tiket' => 'required',
        'tiketWisata.deskripsi' => '',
        'tiketWisata.harga' => 'required|int',
    ];

    public function mount()
    {
        $this->tiketWisata = new Tiket();
    }

    public function render()
    {
        $tiket = Tiket::where('id_wisata', auth()->user()->id_wisata)->get();

        return view('livewire.wisata.ticketing-wisata', [
            'tiket' => $tiket,
        ]);
    }

    public function resetInput()
    {
        $this->tiketWisata = new Tiket();
        $this->resetErrorBag();
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

        $this->resetInput();
        $this->emit('tiketDeleted');
    }
}
