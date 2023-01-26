<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Wisata;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarUser extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    
    public $search;
    public $sortBy = 'id_wisata';
    public $sortAsc = true;
    public $userWisata;

    public $deleteConfirmation = false;
    public $addConfirmation = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id_wisata'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules = [
        'userWisata.name' => 'required|string|max:255',
        'userWisata.username' => 'required|string|max:255',
        'userWisata.password' => 'required|string|max:255',
        'userWisata.email' => 'required|string|max:255',
        'userWisata.id_wisata' => 'required',
    ];

    public function render()
    {
        $users = User::with('wisata')
        ->when($this->search, function($query){
            $query->where('name', 'like', '%'.$this->search.'%')
                ->orWhere('username', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orWhere('id_wisata', 'like', '%'.$this->search.'%');
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'asc' : 'desc');

        $users = $users->paginate(10);

        $wisata = Wisata::all();

        return view('livewire.dinas.daftar-user', [
            'users' => $users,
            'wisata' => $wisata,
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
        User::destroy($this->userWisata->id_wisata);
        session()->flash('message', 'User berhasil dihapus');

        $this->resetInput();
        $this->emit('userDeleted');
    }
}
