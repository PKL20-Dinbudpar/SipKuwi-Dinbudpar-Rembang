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
                            <button wire:click="resetInput()" data-bs-toggle="modal" data-bs-target="#createTiketModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Tiket</button>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="row justify-content-center">
                            @foreach ($tikets as $tkt)    
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

        <div class="row mt-0 d-flex justify-content-center">
            <div class="col-lg-5 mb-lg-0 mb-4">
              <div class="card">
                <div class="card-header pb-2">
                    <div class="d-flex flex-row justify-content-center">
                        <h5 class="mb-0">Tambah Pengunjung</h5>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-row justify-content-center">
                     
                        <button data-bs-toggle="modal" data-bs-target="#createTransaksiModal" wire:click="resetInputTransaksi()" 
                            class="btn btn-lg btn-block bg-gradient-dark">
                        +
                        </button>

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
                        <div>
                            @isset($tiketWisata->id_tiket)
                                <button type="button" wire:click="deleteTiket({{ $tiketWisata->id_tiket }})" class="btn bg-gradient-danger" 
                                    data-bs-toggle="modal" data-bs-target="#deleteTiketModal" data-bs-dismiss="modal">Hapus</button>
                            @endisset
                        </div>
                        <div>
                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </x-slot>
        </x-modal>

        {{-- Modal Delete --}}
        <x-modal> 
            <x-slot name="id"> deleteTiketModal </x-slot>
            <x-slot name="title">
                Hapus Tiket
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="destroyTiket">
                    <div class="modal-body">
                        <h6>Apa anda yakin ingin menghapus tiket ini?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn bg-gradient-primary">Hapus</button>
                    </div>
                </form>
            </x-slot>
        </x-modal>

        {{-- Modal createTransaksi --}}
        <x-modal-tiket> 
            <x-slot name="id"> createTransaksiModal </x-slot>

            <x-slot name="customClass">
                modal-xl
            </x-slot>

            <x-slot name="title">
                Tambah Pengunjung
            </x-slot>

            <x-slot name="content">
                <form wire:submit.prevent="submitTransaksi">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Jenis Wisatawan</label>
                            <select wire:model.defer="jenisWisatawan" class="form-control" aria-label="Default select example">
                                <option value="wisnus">Wisatawan Nusantara</option>
                                <option value="wisman">Wisatawan Mancanegara</option>
                            </select>
                        </div>
                        <table class="table mb-3">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah Tiket</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiket as $tiket)
                                    <tr>
                                        <td>{{ $tiket->nama_tiket }}</td>
                                        <td>
                                            <input type="number" wire:model="jumlahTiket.{{ $tiket->id_tiket }}" class="form-control">
                                        </td>
                                        <td>Rp {{ number_format($tiket->harga,0,",",".") }}</td>
                                        <td>
                                            Rp {{ number_format($hargaTiket[$tiket->id_tiket] * (int)$jumlahTiket[$tiket->id_tiket],0,",",".") }}
                                        </td>
                                    </tr>
                                    {{-- error message --}}
                                    @error('jumlahTiket.'.$tiket->id_tiket)
                                        <tr>
                                            <td colspan="4">
                                                <span class="text-danger">{{ $message }}</span>
                                            </td>
                                        </tr>
                                    @enderror
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total</td>
                                    <td>
                                        Rp {{ number_format(array_sum(array_map(function($count, $price) {
                                            return (int)$count * $price;
                                        }, $jumlahTiket, $hargaTiket)),0,",",".") }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mb-3">
                            <label>Uang Masuk</label>
                            <input type="number" wire:model.lazy="uangMasuk" placeholder="Uang Masuk" class="form-control">

                            @error('uangMasuk')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Kembalian</label>
                            <input type="number" wire:model.lazy="kembalian" placeholder="Kembalian" class="form-control">

                            @error('kembalian')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <div>
                            @isset($tiketWisata->id_tiket)
                                <button type="button" wire:click="deleteTiket({{ $tiketWisata->id_tiket }})" class="btn bg-gradient-danger" 
                                    data-bs-toggle="modal" data-bs-target="#deleteTiketModal" data-bs-dismiss="modal">Hapus</button>
                            @endisset
                        </div>
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