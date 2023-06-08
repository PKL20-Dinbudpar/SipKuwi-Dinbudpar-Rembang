<main class="main-content">
    <div class="container-fluid py-4">

        @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show">
            <div class=" d-flex flex-row alert alert-success mx-0 mb-2 justify-content-between">
                <div >
                    {{ session('message') }}
                </div>
                <div class="d-flex">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="show = false"></button>
                </div>
            </div>
        </div>
        @endif

        {{-- Tables --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div>
                            <h5 class="mb-3">Daftar User</h5>
                        </div>
                        
                        <div class="d-flex flex-row justify-content-between mb-1">
                            <div class="form-group mb-0 col-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        &#x1F50E;&#xFE0E;
                                    </span>
                                    <input wire:model="search" type="text" class="form-control" placeholder="Cari User" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="d-flex">
                                <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm d-none d-md-block mb-0 mx-2"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#createUserModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah User</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama User
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Username
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No HP
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tempat Tanggung Jawab
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $users->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->name }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->username }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->email ?? "-"}}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->phone ?? "-"}}
                                            </p>
                                        </td>
                                        <td class="align-middle text-sm">
                                            @if ($user->role == 'dinas')
                                                <span class="badge badge-sm bg-gradient-danger">dinas</span>
                                            @elseif($user->role == 'wisata')
                                                <span class="badge badge-sm bg-gradient-info">wisata</span>
                                            @elseif($user->role == 'hotel')
                                                <span class="badge badge-sm bg-gradient-secondary">hotel</span>
                                            @endif
                                          </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if($user->role == 'wisata')
                                                    {{ $user->wisata->nama_wisata ?? "-" }}
                                                @elseif($user->role == 'hotel')
                                                    {{ $user->hotel->nama_hotel ?? "-" }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </td>
                                        <td class="">
                                            <span data-bs-toggle="modal" data-bs-target="#createUserModal" wire:click="editUser({{ $user->id }})"
                                                class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit User">
                                                <i class="cursor-pointer fas fa-user-edit text-secondary"></i>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#deleteUserModal" wire:click="deleteUser({{ $user->id }})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tambah User --}}
                    <x-modal> 
                        <x-slot name="id"> createUserModal </x-slot>
                        <x-slot name="title">
                            @isset($userWisata->id)
                                Edit User
                            @else
                                Tambah User
                            @endisset
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="saveUser">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama User</label>
                                        <input type="text" wire:model.defer="userWisata.name" class="form-control">
                                        @error('userWisata.name')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Username</label>
                                        <input type="text" wire:model.defer="userWisata.username" class="form-control">
                                        @error('userWisata.username')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Password</label>
                                        <input type="password" wire:model.defer="pass" class="form-control">
                                        @error('pass')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Email (Opsional)</label>
                                        <input type="text" wire:model.defer="userWisata.email" class="form-control">
                                        @error('userWisata.email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>No HP (Opsional)</label>
                                        <input type="text" wire:model.defer="userWisata.phone" class="form-control">
                                        @error('userWisata.phone')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select wire:model.defer="userWisata.role" id="selectRole" onchange="showByRole()" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Role</option>
                                            <option value="dinas">Dinas</option>
                                            <option value="wisata">Wisata</option>
                                            <option value="hotel">Hotel</option>
                                        </select>
                                        @error('userWisata.role')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div id="selectWisata" @if (!isset($userWisata->id) || $userWisata->role != 'wisata') hidden @endif class="mb-3">
                                        <label>Nama Wisata</label>
                                        <select wire:model.defer="userWisata.id_wisata" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Wisata</option>
                                            @foreach ($wisata as $item)
                                                <option value="{{ $item->id_wisata }}">{{ $item->nama_wisata }}</option>
                                            @endforeach
                                        </select>
                                        @error('userWisata.id_wisata')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div id="selectHotel" @if (!isset($userWisata->id) || $userWisata->role != 'hotel') hidden @endif class="mb-3">
                                        <label>Nama Hotel</label>
                                        <select wire:model.defer="userWisata.id_hotel" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Hotel</option>
                                            @foreach ($hotel as $item)
                                                <option value="{{ $item->id_hotel }}">{{ $item->nama_hotel }}</option>
                                            @endforeach
                                        </select>
                                        @error('userWisata.id_hotel')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                </div>
                            </form>

                            <script>
                                function showByRole() {
                                    var role = document.getElementById("selectRole").value;
                                    if (role == 'wisata') {
                                        document.getElementById("selectWisata").hidden = false;
                                        document.getElementById("selectHotel").hidden = true;
                                    } else if (role == 'hotel') {
                                        document.getElementById("selectHotel").hidden = false;
                                        document.getElementById("selectWisata").hidden = true;
                                    } else {
                                        document.getElementById("selectWisata").hidden = true;
                                        document.getElementById("selectHotel").hidden = true;
                                    }
                                }    
                            </script>
                        </x-slot>
                    </x-modal>

                    {{-- Modal Delete Wisata --}}
                    <x-modal> 
                        <x-slot name="id"> deleteUserModal </x-slot>
                        <x-slot name="title">
                            Hapus User
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="destroyUser">
                                <div class="modal-body">
                                    <h6>Apa anda yakin ingin menghapus user ini?</h6>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn bg-gradient-primary">Hapus</button>
                                </div>
                            </form>
                        </x-slot>
                    </x-modal>
                </div>
            </div>
        </div>
    </div>    
</main>



