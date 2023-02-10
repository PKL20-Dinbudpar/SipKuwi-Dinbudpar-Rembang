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
                            <h5 class="mb-3">Daftar Hotel Rembang</h5>
                        </div>
                        
                        <div class="d-flex flex-row justify-content-between mb-1">
                            <div class="form-group mb-0 col-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        &#x1F50E;&#xFE0E;
                                    </span>
                                    <input wire:model="search" type="text" class="form-control" placeholder="Cari Hotel/Alamat/Kecamatan" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="d-flex">
                                <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm d-none d-md-block mb-0 mx-2"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#createHotelModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Hotel</button>
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
                                            Nama Hotel
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
                                    @foreach ($hotels as $hotel)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $hotels->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $hotel->nama_hotel }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $hotel->alamat ?? '' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $hotel->kecamatan->nama_kecamatan ?? '' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <span data-bs-toggle="modal" data-bs-target="#createHotelModal" wire:click="editHotel({{ $hotel->id_hotel }})"
                                                class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Hotel">
                                                <i class="cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#deleteHotelModal" wire:click="deleteHotel({{ $hotel->id_hotel }})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="p-4">
                                {{ $hotels->links() }}
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tambah Hotel --}}
                    <x-modal> 
                        <x-slot name="id"> createHotelModal </x-slot>
                        <x-slot name="title">
                            @isset($hotelWisata->id_hotel)
                                Edit Hotel
                            @else
                                Tambah Hotel
                            @endisset
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="saveHotel">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nama Hotel</label>
                                        <input type="text" wire:model.defer="hotelWisata.nama_hotel" class="form-control">
                                        @error('hotelWisata.nama_hotel')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Alamat (Desa)</label>
                                        <input type="text" wire:model.defer="hotelWisata.alamat" class="form-control">
                                        @error('hotelWisata.alamat')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="mb-3">
                                        <label>Kecamatan</label>
                                        <select wire:model.defer="hotelWisata.id_kecamatan" class="form-control" aria-label="Default select example">
                                            <option value="">Pilih Kecamatan</option>
                                            @foreach ($kecamatan as $item)
                                                <option value="{{ $item->id_kecamatan }}">{{ $item->nama_kecamatan }}</option>
                                            @endforeach
                                        </select>
                                        @error('hotelWisata.id_kecamatan')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                                </div>
                            </form>
                        </x-slot>
                    </x-modal>

                    {{-- Modal Delete Hotel --}}
                    <x-modal> 
                        <x-slot name="id"> deleteHotelModal </x-slot>
                        <x-slot name="title">
                            Hapus Objek Hotel
                        </x-slot>

                        <x-slot name="content">
                            <form wire:submit.prevent="destroyHotel">
                                <div class="modal-body">
                                    <h6>Apa anda yakin ingin menghapus hotel ini beserta usernya?</h6>
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



