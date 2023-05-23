<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\WisataExport;
use App\Models\Kecamatan;
use App\Models\User;
use App\Models\Wisata;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DaftarWisata extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $search;
    public $objWisata;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'objWisata.nama_wisata' => 'required|string|max:255',
        'objWisata.alamat' => 'required|string|max:255',
        'objWisata.id_kecamatan' => 'required',
    ];

    public function render()
    {
        $wisata = Wisata::with('kecamatan')
                ->leftjoin('kecamatan', 'wisata.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->when($this->search, function($query){
                    $query->where('nama_wisata', 'like', '%'.$this->search.'%')
                        ->orWhere('alamat', 'like', '%'.$this->search.'%')
                        ->orWhere('kecamatan.nama_kecamatan', 'like', '%'.$this->search.'%');
                })
                ->orderBy('id_wisata', 'asc');

        $wisata = $wisata->paginate(10);

        $kecamatan = Kecamatan::all();

        return view('livewire.dinas.daftar-wisata', [
            'wisata' => $wisata,
            'kecamatan' => $kecamatan,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset(['objWisata']);
        $this->resetErrorBag();
    }

    public function editWisata(Wisata $wisata)
    {
        $this->resetErrorBag();
        $this->objWisata = $wisata;
    }

    public function saveWisata()
    {
        // validate with custom error message
        $this->validate([
            'objWisata.nama_wisata' => 'required|string|max:255',
            'objWisata.alamat' => 'required|string|max:255',
            'objWisata.id_kecamatan' => 'required',
        ], [
            'objWisata.nama_wisata.required' => 'Nama objek wisata tidak boleh kosong',
            'objWisata.alamat.required' => 'Alamat objek wisata tidak boleh kosong',
            'objWisata.id_kecamatan.required' => 'Kecamatan objek wisata tidak boleh kosong',
        ]);

        if (isset($this->objWisata->id_wisata)) {
            $this->objWisata->save();
            session()->flash('message', 'Objek wisata berhasil diubah');
        }
        else {
            Wisata::create($this->objWisata);
            session()->flash('message', 'Objek wisata berhasil ditambahkan');
        }

        $this->resetInput();
        $this->emit('wisataSaved');
    }

    public function deleteWisata(Wisata $wisata)
    {
        $this->objWisata = $wisata;
    }

    public function destroyWisata()
    {
        Wisata::destroy($this->objWisata->id_wisata);
        User::where('id_wisata', $this->objWisata->id_wisata)->delete();
        session()->flash('message', 'Objek Wisata berhasil dihapus');

        $this->resetInput();
        $this->emit('wisataDeleted');
    }

    public function export()
    {
        return Excel::download(new WisataExport, 'DaftarWisata.xlsx');
    }
}
