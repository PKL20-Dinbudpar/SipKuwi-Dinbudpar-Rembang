<?php

namespace App\Http\Livewire\Dinas;

use App\Exports\WisataExport;
use App\Models\Kecamatan;
use App\Models\Wisata;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DaftarWisata extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';


    public $search;
    public $sortBy = 'id_wisata';
    public $sortAsc = true;
    public $objWisata;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id_wisata'],
        'sortAsc' => ['except' => true],
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
                ->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc');

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

    public function sortBy($field)
    {
        if ($this->sortBy == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }
        $this->sortBy = $field;
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
        $this->validate();

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
        session()->flash('message', 'Objek Wisata berhasil dihapus');

        $this->resetInput();
        $this->emit('wisataDeleted');
    }

    public function export()
    {
        return Excel::download(new WisataExport, 'DaftarWisata.xlsx');
    }
}
