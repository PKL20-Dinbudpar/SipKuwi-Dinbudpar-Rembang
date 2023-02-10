<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\HotelExport;
use App\Models\Hotel;
use App\Models\Kecamatan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DaftarHotel extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $sortBy = 'id_hotel';
    public $sortAsc = true;

    public $deleteConfirmation = false;
    public $hotelWisata;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id_hotel'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'hotelWisata.nama_hotel' => 'required|string|max:255',
        'hotelWisata.alamat' => 'required|string|max:255',
        'hotelWisata.id_kecamatan' => 'required',
    ];

    public function render()
    {
        $hotels = Hotel::with('kecamatan')
                ->leftjoin('kecamatan', 'hotel.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->when($this->search, function($query){
                    $query->where('nama_hotel', 'like', '%'.$this->search.'%')
                        ->orWhere('alamat', 'like', '%'.$this->search.'%')
                        ->orWhere('kecamatan.nama_kecamatan', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc');

        $hotels = $hotels->paginate(10);

        $kecamatan = Kecamatan::all();

        return view('livewire.dinas.daftar-hotel', [
            'hotels' => $hotels,
            'kecamatan' => $kecamatan,
        ]);
    }

    public function resetInput()
    {
        $this->reset(['hotelWisata']);
        $this->resetErrorBag();
    }

    public function editHotel(Hotel $hotel)
    {
        $this->resetErrorBag();
        $this->hotelWisata = $hotel;
    }

    public function saveHotel(){
        $this->validate();
        
        if (isset($this->hotelWisata->id_hotel)) {
            $this->hotelWisata->save();
            session()->flash('message', 'Hotel berhasil diubah');
        }
        else {
            Hotel::create($this->hotelWisata);
            session()->flash('message', 'Hotel berhasil ditambahkan');
        }

        $this->resetInput();
        $this->emit('hotelSaved');
    }

    public function deleteHotel(Hotel $hotel)
    {
        $this->hotelWisata = $hotel;
    }

    public function destroyHotel()
    {
        Hotel::destroy($this->hotelWisata->id_hotel);
        User::where('id_hotel', $this->hotelWisata->id_hotel)->delete();
        session()->flash('message', 'Hotel berhasil dihapus');

        $this->resetInput();
        $this->emit('hotelDeleted');
    }

    public function export()
    {
        return Excel::download(new HotelExport, 'DaftarHotel.xlsx');
    }
}
