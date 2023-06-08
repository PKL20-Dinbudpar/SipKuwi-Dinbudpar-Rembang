<?php

namespace App\Http\Livewire\Dinas;

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
    public $userWisata;
    public $pass;

    public $deleteConfirmation = false;
    public $addConfirmation = false;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'userWisata.name' => 'required|string|max:255',
        'userWisata.username' => 'required|string|max:255',
        'userWisata.email' => 'email|max:255',
        'userWisata.role' => 'required',
        'userWisata.id_wisata' => 'required_if:userWisata.role,wisata',
        'userWisata.id_hotel' => 'required_if:userWisata.role,hotel',
        'userWisata.phone' => 'nullable|numeric|digits_between:10,15',

        'pass' => 'required|string',
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
        ->orderBy('role', 'asc')
        ->orderBy('users.id_hotel', 'asc')
        ->orderBy('users.id_wisata', 'asc');

        $users = $users->paginate(10);

        $wisata = Wisata::all()->sortBy('nama_wisata');

        $hotel = Hotel::all()->sortBy('nama_hotel');

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
        // $this->validate();
        // validate with custom error message
        $this->validate([
            'userWisata.name' => 'required|string|max:255',
            'userWisata.username' => 'required|string|max:255',
            'userWisata.email' => 'email|max:255',
            'userWisata.role' => 'required',
            'userWisata.id_wisata' => 'required_if:userWisata.role,wisata',
            'userWisata.id_hotel' => 'required_if:userWisata.role,hotel',
            'userWisata.phone' => 'nullable|numeric|digits_between:10,15',
            'pass' => 'required|string',
        ], [
            'userWisata.name.required' => 'Nama tidak boleh kosong',
            'userWisata.username.required' => 'Username tidak boleh kosong',
            'userWisata.email.email' => 'Email tidak valid',
            'userWisata.role.required' => 'Role tidak boleh kosong',
            'userWisata.id_wisata.required_if' => 'Wisata tidak boleh kosong',
            'userWisata.id_hotel.required_if' => 'Hotel tidak boleh kosong',
            'userWisata.phone.numeric' => 'Nomor telepon harus berupa angka',
            'userWisata.phone.digits_between' => 'Nomor telepon tidak valid',
            'pass.required' => 'Password tidak boleh kosong',
        ]);



        if (isset($this->userWisata->id)) {
            $this->userWisata->password = bcrypt($this->pass);
            $this->userWisata->save();
            session()->flash('message', 'User berhasil diubah');
        }
        else {
            // Exception for non duplicate username
            $this->validate([
                'userWisata.username' => 'unique:users,username',
            ], [
                'userWisata.username.unique' => 'Username sudah digunakan',
            ]);

            // Exception for non duplicate email
            $this->validate([
                'userWisata.email' => 'unique:users,email',
            ], [
                'userWisata.email.unique' => 'Email sudah digunakan',
            ]);

            // exception for non duplicate phone
            $this->validate([
                'userWisata.phone' => 'unique:users,phone',
            ],[
                'userWisata.phone.unique' => 'Nomor telepon sudah digunakan',
            ]);

            $this->userWisata['password'] = bcrypt($this->pass);
            User::create($this->userWisata);
            session()->flash('message', 'User berhasil ditambahkan');
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
        if ($this->userWisata->id == auth()->user()->id) {
            session()->flash('message', 'User gagal dihapus');
            $this->emit('userDeleted');
            return;
        }

        User::destroy($this->userWisata->id);
        session()->flash('message', 'User berhasil dihapus');

        $this->resetInput();
        $this->emit('userDeleted');
    }

    public function export()
    {
        return Excel::download(new UserExport, 'DaftarUser.xlsx');
    }
}
