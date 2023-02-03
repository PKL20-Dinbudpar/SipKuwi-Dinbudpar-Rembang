<?php

namespace App\Http\Livewire;

use App\Exports\UserExport;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Wisata;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class DaftarUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    
    public $search;
    public $sortBy = 'wisata.id_wisata';
    public $sortAsc = true;
    public $userWisata;

    public $deleteConfirmation = false;
    public $addConfirmation = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'wisata.id_wisata'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'userWisata.name' => 'required|string|max:255',
        'userWisata.username' => 'required|string|max:255',
        'userWisata.pass' => 'required|string|min:8',
        'userWisata.email' => 'email|max:255',
        'userWisata.role' => 'required',
        'userWisata.id_wisata' => 'required_if:userWisata.role,wisata',
        'userWisata.id_hotel' => 'required_if:userWisata.role,hotel',
    ];

    public function render()
    {
        $users = User::with('wisata', 'hotel')
        ->leftjoin('wisata', 'users.id_wisata', '=', 'wisata.id_wisata')
        ->leftjoin('hotel', 'users.id_hotel', '=', 'hotel.id_hotel')
        ->when($this->search, function($query){
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('username', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('wisata.nama_wisata', 'like', '%'.$this->search.'%')
                ->orWhere('hotel.nama_hotel', 'like', '%'.$this->search.'%');
        })
        ->orderBy('role', 'asc');

        $users = $users->paginate(10);

        $wisata = Wisata::all();

        $hotel = Hotel::all();

        return view('livewire.dinas.daftar-user', [
            'users' => $users,
            'wisata' => $wisata,
            'hotel' => $hotel,
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
        $this->reset(['userWisata']);
        $this->resetErrorBag();
    }

    public function editUser(User $users)
    {
        $this->resetErrorBag();
        $this->userWisata = $users;
    }

    public function saveUser()
    {
        $this->validate();

        if (isset($this->userWisata->id)) {
            $this->userWisata->save();
            session()->flash('message', 'Data user berhasil diubah');
        }
        else {
            $this->userWisata += ['pass' => $this->userWisata['pass']];
            $this->userWisata['password'] = bcrypt($this->userWisata['pass']);
            User::create($this->userWisata);
            session()->flash('message', 'Data user berhasil ditambahkan');
        }

        $this->resetInput();
        $this->emit('userSaved');
    }

    public function deleteUser(User $users)
    {
        $this->userWisata = $users;
    }

    public function destroyUser()
    {
        User::destroy($this->userWisata->id);
        session()->flash('message', 'Data user berhasil dihapus');

        $this->resetInput();
        $this->emit('userDeleted');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'DaftarUser.xlsx');
    }
}
