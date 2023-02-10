<main class="main-content">
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div class="card px-4 mb-4 bg-gray-50">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-2">Rekap Hari Ini - {{ date("d M Y") }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div
                                                class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-users opacity-10"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Pengunjung Domestik</h6>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">
                                                {{ $todayRekap->wisatawan_nusantara ?? "-" }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div
                                                class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-users opacity-10"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Pengunjung Mancanegara</h6>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">
                                                {{ $todayRekap->wisatawan_mancanegara ?? "-" }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header mx-4 p-3 text-center">
                                            <div
                                                class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                                <i class="fas fa-money opacity-10"></i>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0 p-3 text-center">
                                            <h6 class="text-center mb-0">Kamar Terjual</h6>
                                            <hr class="horizontal dark my-3">
                                            <h5 class="mb-0">
                                                {{ $todayRekap->kamar_terjual ?? "-" }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button data-bs-toggle="modal" data-bs-target="#editRekapModal" 
                                    @isset($todayRekap) wire:click="editRekap({{ $todayRekap->id_rekap }})" @endisset class="btn bg-gradient-info">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="card mb-4">
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
                            <h6>Histori Rekap</h6>
                        </div>

                        <div class="d-flex flex-row justify-content-between my-2">
                            <div class="form-group mb-0">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        &#x1F4C5;&#xFE0E;
                                    </span>
                                    <select wire:model="tanggal" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Tanggal &nbsp; &nbsp; &nbsp;</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select wire:model="bulan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Bulan &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                    <select wire:model="tahun" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Tahun &nbsp; &nbsp; &nbsp;</option>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm d-none d-lg-block mb-0 mx-2"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#editRekapModal" class="btn bg-gradient-primary btn-sm d-sm-block d-md-none mx-2 mb-0">+&nbsp;</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#editRekapModal" class="btn bg-gradient-primary btn-sm mb-0 d-none d-md-block">+&nbsp; Tambah Data</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                      <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                          <thead>
                            <tr>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengunjung Domestik</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengunjung Mancanegara</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kamar Terjual</th>
                              <th class="text-secondary opacity-7"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($rekap as $item)
                                <tr>
                                    <td class="ps-4">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $loop->iteration }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $item->tanggal->format('d M Y') }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $item->wisatawan_nusantara }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $item->wisatawan_mancanegara }}
                                        </p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">
                                            {{ $item->kamar_terjual }}
                                        </p>
                                    </td>
                                    <td class="align-middle">
                                        <span data-bs-toggle="modal" data-bs-target="#editRekapModal" wire:click="editRekap({{ $item->id_rekap }})"
                                            class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit Rekap">
                                            <i class="cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                                        </span>
                                        <span data-bs-toggle="modal" data-bs-target="#deleteRekapModal" wire:click="deleteRekap({{ $item->id_rekap }})">
                                            <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                          </tbody>
                        </table>

                        <div class="p-4">
                            {{ $rekap->links() }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                {{-- Modal Edit --}}
                <x-modal> 
                    <x-slot name="id"> editRekapModal </x-slot>
                    <x-slot name="title">
                        @isset($dataRekap->id_rekap)   
                            Edit Rekap
                        @else
                            Tambah Rekap
                        @endisset
                    </x-slot>

                    <x-slot name="content">
                        <form wire:submit.prevent="saveRekap">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Tanggal</label>
                                    <input type="date" wire:model.defer="dataRekap.tanggal" class="form-control" 
                                    @isset($dataRekap->id_rekap) disabled @endisset>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Pengunjung Domestik</label>
                                    <input type="number" wire:model.defer="dataRekap.wisatawan_nusantara" class="form-control">
                                    @error('dataRekap.wisatawan_nusantara')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Pengunjung Mancanegara</label>
                                    <input type="number" wire:model.defer="dataRekap.wisatawan_mancanegara" class="form-control">
                                    @error('dataRekap.wisatawan_mancanegara')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Kamar Terjual</label>
                                    <input type="number" wire:model.defer="dataRekap.kamar_terjual" class="form-control">
                                    @error('dataRekap.kamar_terjual')<span class="text-danger">{{ $message }}</span>@enderror
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

                {{-- Modal Delete --}}
                <x-modal> 
                    <x-slot name="id"> deleteRekapModal </x-slot>
                    <x-slot name="title">
                        Hapus Rekap
                    </x-slot>

                    <x-slot name="content">
                        <form wire:submit.prevent="destroyRekap">
                            <div class="modal-body">
                                @if ($deleteRekap)
                                    {{-- <input type="hidden" wire:model.defer="deleteRekap.id_rekap" class="form-control"> --}}
                                    <h6>Apa anda yakin ingin menghapus rekap pada tanggal <br>{{ $deleteRekap->tanggal->format('d M Y') }}?</h6>
                                @endif
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
</main>
