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
                            <div class="d-flex">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="show = false"></button>
                            </div>
                        </div>
                    @endif
                    <div class="card-header pb-0">
                        <div>
                            <h5 class="mb-3">Daftar Objek Wisata Rembang</h5>
                        </div>
                        
                        <div class="d-flex flex-row justify-content-between mb-1">
                            <div class="form-group mb-0 col-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        &#x1F50E;&#xFE0E;
                                    </span>
                                    <input wire:model="search" type="text" class="form-control" placeholder="Cari Wisata/Alamat/Kecamatan" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="d-flex">
                                <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm d-none d-md-block mb-0 mx-2"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#createWisataModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Wisata</button>
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
                                            Nama Objek Wisata
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Alamat
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Kecamatan
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wisata as $objek)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $wisata->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $objek->nama_wisata }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $objek->alamat ?? '' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $objek->kecamatan->nama_kecamatan ?? '' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <span data-bs-toggle="modal" data-bs-target="#createWisataModal" wire:click="editWisata({{ $objek->id_wisata }})"
                                                class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Wisata">
                                                <i class="cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#deleteWisataModal" wire:click="deleteWisata({{ $objek->id_wisata }})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $wisata->links() }}
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tambah Wisata --}}
                    <x-modal> 
                        <x-slot name="id"> createWisataModal </x-slot>
                        <x-slot name="title">
                            @isset($objWisata->id_wisata)
                                Edit Objek Wisata
                            @else
                                Tambah Objek Wisata
                            @endisset
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="saveWisata">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Objek Wisata</label>
                                        <input type="text" wire:model.defer="objWisata.nama_wisata" class="form-control">
                                        @error('objWisata.nama_wisata')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Alamat (Desa)</label>
                                        <input type="text" wire:model.defer="objWisata.alamat" class="form-control">
                                        @error('objWisata.alamat')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Kecamatan</label>
                                        <select wire:model.defer="objWisata.id_kecamatan" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                        @error('objWisata.id_kecamatan')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                </div>
                            </form>
                        </x-slot>
                    </x-modal>

                    {{-- Modal Delete Wisata --}}
                    <x-modal> 
                        <x-slot name="id"> deleteWisataModal </x-slot>
                        <x-slot name="title">
                            Hapus Objek Wisata
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="destroyWisata">
                                <div class="modal-body">
                                    <h6>Apa anda yakin ingin menghapus objek wisata ini?</h6>
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



