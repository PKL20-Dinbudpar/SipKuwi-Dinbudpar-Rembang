<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card px-4 mb-4 bg-gray-50">
                    <div class="card-header pb-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Daftar Tiket</h5>
                            </div>
                            <button data-bs-toggle="modal" data-bs-target="#createTiketModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Tiket</button>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row justify-content-center">
                            @foreach ($tiket as $tkt)    
                                <div class="col-xl-3 col-sm-6 mb-0">
                                    <div data-bs-toggle="modal" data-bs-target="#createTiketModal" wire:click="editTiket({{ $tkt->id_tiket }})"
                                        class="card btn">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-8 text-start">
                                                    <div class="numbers">
                                                        <p class="text-md mb-0 text-capitalize font-weight-bold">{{ $tkt->nama_tiket }}</p>
                                                        <h5 class="font-weight-bolder mb-0">
                                                            Rp {{ number_format($tkt->harga,0,",",".") }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        {{-- Modal createTiket --}}
        <x-modal> 
            <x-slot name="id"> createTiketModal </x-slot>
            <x-slot name="title">
                @isset($tiketWisata->id_tiket)
                    Info Tiket
                @else
                    Tambah Tiket
                @endisset
                
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="saveTiket">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Tiket</label>
                            <input type="text" wire:model.defer="tiketWisata.nama_tiket" class="form-control">
                            @error('tiketWisata.nama_tiket')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label>Deskripsi Tiket</label>
                            <textarea wire:model.defer="tiketWisata.deskripsi" class="form-control" rows="3"></textarea>
                            @error('tiketWisata.deskripsi')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label>Harga Tiket</label>
                            <input type="number" wire:model.defer="tiketWisata.harga" class="form-control">
                            @error('tiketWisata.harga')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                        
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        @isset($tiketWisata->id_tiket)
                            <button type="button" wire:click="deleteTiket({{ $tiketWisata->id_tiket }})" class="btn bg-gradient-danger">Hapus</button>
                        @endisset
                        <div>
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </x-slot>
        </x-modal>

    </div>
</main>