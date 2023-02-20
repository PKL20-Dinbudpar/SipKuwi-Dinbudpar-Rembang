<main class="main-content">
    <div class="container-fluid pt=0">

        <div class="row mt-0 py-2">
            {{-- Back link with icon --}}
            <div class="col-12">
                <a href="{{ route('rekap-wisata-harian') }}" class="text-decoration-none">
                    <div class="d-flex flex-row align-items-center">
                        <i class="fa fa-arrow-left" style="font-size:12px"></i>
                        <span class="ms-2">Kembali</span>
                    </div>
                </a>
            </div>
        </div>

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

        <div class="row">
            <div class="col-12">
                {{-- Grafik Kunjungan Wisata --}}
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div>
                            <h5>Grafik Kunjungan {{ $wisata->nama_wisata }}</h5>
                        </div>
                    </div>
                    <div class="card-body px-4 pt-0 pb-4">
                        {{-- Tahun Selector --}}
                        <div class="flex-row d-flex justify-content-between">
                            <div class="form-group d-flex">
                                <select class="form-control px-5" wire:model="tahunChart" id="tahun" name="tahun">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option value="{{ $i }}" @selected(date('Y') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="d-flex">
                                <button class="btn bg-gradient-success" wire:click="showGraph">
                                    @if (!$showGraph)
                                        Tampilkan Grafik
                                    @else
                                        Sembunyikan Grafik
                                    @endif
                                </button>
                            </div>
                        </div>
        
                        {{-- Chart --}}
                        @if ($showGraph)
                        <div class="d-lg-flex">
                            <div class="shadow rounded p-4 border bg-white col-lg-5 col-md-12 mx-5" style="height: 20rem;">
                                <livewire:livewire-line-chart
                                    key="{{ $wisatawanChart->reactiveKey() }}"
                                    :line-chart-model="$wisatawanChart"
                                />
                            </div>
                            <div class="shadow rounded p-4 border bg-white col-lg-5 col-md-12 mx-5" style="height: 20rem;">
                                <livewire:livewire-column-chart
                                    :column-chart-model="$pendapatanChart"
                                />
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- Tabel --}}
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div>
                            <h4>Rekap Kunjungan {{ $wisata->nama_wisata }}</h4>
                        </div>

                        <div class="d-flex flex-row justify-content-between mt-3 mb-2">
                            <div class="form-group mb-0">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">
                                        &#x1F4C5;&#xFE0E;
                                    </span>
                                    <select wire:model="tanggal" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                        <option value="">Tanggal &nbsp; &nbsp; &nbsp;</option>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @if ($i < 10)
                                                <option value="0{{ $i }}">0{{ $i }}</option>
                                                @continue
                                            @endif
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
                                        <option value="">Tahun &nbsp;</option>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="d-flex">
                                <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm d-none d-lg-block mb-0 mx-2"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                                <button wire:click="resetInput" data-bs-toggle="modal" data-bs-target="#editRekapModal" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Data</button>
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
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wisatawan Nusantara</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Wisatawan Mancanegara</th>
                              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Pendapatan</th>
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
                                            {{ $item->total_pendapatan }}
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
                                    <label>Jumlah Wisatawan Nusantara</label>
                                    <input type="number" wire:model.defer="dataRekap.wisatawan_nusantara" class="form-control">
                                    @error('dataRekap.wisatawan_nusantara')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Wisatawan Mancanegara</label>
                                    <input type="number" wire:model.defer="dataRekap.wisatawan_mancanegara" class="form-control">
                                    @error('dataRekap.wisatawan_mancanegara')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                                <div class="mb-3">
                                    <label>Total Pendapatan</label>
                                    <input type="number" wire:model.defer="dataRekap.total_pendapatan" class="form-control">
                                    @error('dataRekap.total_pendapatan')<span class="text-danger">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                                <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                            </div>
                        </form>
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
