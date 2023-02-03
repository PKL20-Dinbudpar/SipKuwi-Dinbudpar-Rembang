<main class="main-content">
    <div class="container-fluid py-4">
        
        {{-- Tables --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4 mx-4">
                    @if (session()->has('message'))
                        <div class=" d-flex flex-row alert alert-success mx-3 mb-0 justify-content-between" style="margin-top:30px;" x-data="{ show: true }" x-show="show">
                            <div >
                                {{ session('message') }}
                            </div>
                            <span @click=" show = false ">
                                <i class="fa fa-times" style="font-size:12px"></i>
                            </span>
                        </div>
                    @endif
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
                                    <input wire:model="search" type="text" class="form-control" placeholder="Cari" aria-label="Username" aria-describedby="basic-addon1">
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
                                            Password
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Penanggung Jawab
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
                                            <div class="input-group input-group-sm">
                                                <input id="pass{{ $user->id }}" type="password" class="form-control text-xs font-weight-bold mb-0" 
                                                    value={{ $user->pass }} @disabled(true)>
                                                <button class="btn btn-outline-secondary mb-0" type="button" onclick="showPass({{ $user->id }})">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $user->email }}
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
                                                    {{ $user->wisata->nama_wisata ?? "" }}
                                                @elseif($user->role == 'hotel')
                                                    {{ $user->hotel->nama_hotel ?? "" }}
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

                            <script>
                                function showPass(id) {
                                    var x = document.getElementById("pass"+id);
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }
                            </script>

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
                                    <div @isset($userWisata->id) hidden @endisset class="mb-3">
                                        <label>Password</label>
                                        <input type="text" wire:model.defer="userWisata.password" class="form-control">
                                        @error('userWisata.password')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="text" wire:model.defer="userWisata.email" class="form-control">
                                        @error('userWisata.email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select wire:model.defer="userWisata.role" id="selectRole" onchange="hideWisata()" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Role</option>
                                            <option value="dinas">Dinas</option>
                                            <option value="wisata">Wisata</option>
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
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                </div>
                            </form>

                            <script>
                                function hideWisata() {
                                    var role = document.getElementById("selectRole").value;
                                    if (role == 'wisata') {
                                        document.getElementById("selectWisata").hidden = false;
                                    } else {
                                        document.getElementById("selectWisata").hidden = true;
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



