<div class="container-fluid py-4">
    
    {{-- Tables --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                        <h5 class="mb-3">Daftar Transaksi Hari Ini</h5>
                    </div>

                    <div class="d-flex flex-row justify-content-between my-2">
                        <div class="form-group mb-0">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    &#x1F4C5;&#xFE0E;
                                </span>
                                <select wire:model="tanggal" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Tgl &nbsp; &nbsp; &nbsp;</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        @if ($i < 10)
                                            <option value="0{{ $i }}">0{{ $i }}</option>
                                            @continue
                                        @endif
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <select wire:model="bulan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Bln &nbsp; &nbsp; &nbsp;</option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Okt</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Des</option>
                                </select>
                                <select wire:model="tahun" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Thn &nbsp; &nbsp; &nbsp;</option>
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('ticketing') }}" class="btn bg-gradient-primary d-sm-block d-md-none mx-2 mb-0">+&nbsp;</a>
                            <a href="{{ route('ticketing') }}" class="btn bg-gradient-primary btn-sm d-none d-md-block mb-0">+&nbsp; Tambah Transaksi</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Waktu Transaksi
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Penanggung Jawab
                                    </th>
                                    <th class="text-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jenis Wisatawan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah   
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Pendapatan  
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $data)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $transaksi->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $data->waktu_transaksi }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $data->user->name ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-xs font-weight-bold mb-0">
                                                @if ($data->jenis_wisatawan == 'wisnus')
                                                    <span class="badge badge-sm bg-gradient-success">Nusantara</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-warning">Manca</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $data->jumlah_tiket }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                Rp {{ number_format($data->total_pendapatan,0,",",".") }}
                                            </p>
                                        </td>
                                        <td>
                                            <span data-bs-toggle="modal" data-bs-target="#viewTransaksiModal" wire:click="viewTransaksi({{ $data->id_transaksi }})" class="mx-3">
                                                <i class="cursor-pointer fas fa-file-alt text-secondary"></i>
                                            </span>
                                            <span data-bs-toggle="modal" data-bs-target="#deleteTransaksiModal" wire:click="deleteTransaksi({{ $data->id_transaksi }})">
                                                <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="p-4">
                            {{ $transaksi->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <x-modal> 
        <x-slot name="id"> deleteTransaksiModal </x-slot>
        <x-slot name="title">
            Hapus Transaksi
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="destroyTransaksi">
                <div class="modal-body">
                    <h6>Apa anda yakin ingin menghapus transaksi ini?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn bg-gradient-primary">Hapus</button>
                </div>
            </form>
        </x-slot>
    </x-modal>

    {{-- Modal View --}}
    <x-modal-tiket> 
        <x-slot name="id"> viewTransaksiModal </x-slot>

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
                        @if ($dataTransaksi->jenis_wisatawan == "wisnus")
                            <p class="form-control"> Wisatawan Nusantara </p>
                        @else
                            <p class="form-control"> Wisatawan Mancanegara </p>
                        @endif
                    </div>
                    <div>
                        <label>Transaksi</label>
                        <table class="table mb-3">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Jumlah</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Harga</th>
                                    <th class="text-center text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tiket as $tiket)
                                    <tr>
                                        <td>{{ $tiket->nama_tiket }}</td>
                                        <td class="text-center">
                                            {{ $jumlahTiket[$tiket->id_tiket] }}
                                        </td>
                                        <td>Rp {{ number_format($tiket->harga,0,",",".") }}</td>
                                        <td>
                                            Rp {{ number_format($hargaTiket[$tiket->id_tiket] * (int)$jumlahTiket[$tiket->id_tiket],0,",",".") }}
                                        </td>
                                    </tr>
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
                                    <td colspan="3">Total Pendapatan</td>
                                    <td>
                                        Rp {{ number_format(array_sum(array_map(function($count, $price) {
                                            return (int)$count * $price;
                                        }, $jumlahTiket, $hargaTiket)),0,",",".") }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label>Uang Masuk</label>
                        <p class="form-control"> Rp {{ number_format($dataTransaksi->uang_masuk,0,",",".") }} </p>
                    </div>
                    <div class="mb-3">
                        <label>Jenis Wisatawan</label>
                        <p class="form-control"> Rp {{ number_format($dataTransaksi->kembalian,0,",",".") }} </p>
                    </div>
                    <div class="mb-3">
                        <label>Pendapatan Bersih</label>
                        <p class="form-control"> Rp {{ number_format($dataTransaksi->total_pendapatan,0,",",".") }} </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>