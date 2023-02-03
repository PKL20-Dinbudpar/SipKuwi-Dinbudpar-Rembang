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
                        <h5 class="mb-3">Daftar Transaksi Hari Ini</h5>
                    </div>

                    <div class="d-flex flex-row justify-content-between my-2">
                        <div class="form-group mb-0 col-5">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    &#x1F4C5;&#xFE0E;
                                </span>
                                <select wire:model="tanggal" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Tanggal</option>
                                    @for ($i = 1; $i <= 31; $i++)
                                        @if ($i < 10)
                                            <option value="0{{ $i }}">0{{ $i }}</option>
                                        @else
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endif
                                    @endfor
                                </select>
                                <select wire:model="bulan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                                    <option value="">Bulan</option>
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
                                    <option value="">Tahun</option>
                                    @for ($i = date('Y'); $i >= 2021; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('ticketing') }}" class="btn bg-gradient-primary btn-sm mb-0">+&nbsp; Tambah Transaksi</a>
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
                                        Jenis Tiket
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah   
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Pendapatan  
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
                                            <p class="text-left text-xs font-weight-bold mb-0">
                                                {{ $data->user->name ?? '-' }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-left text-xs font-weight-bold mb-0">
                                                {{ $data->tiket->nama_tiket }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $data->jumlah_tiket }}
                                            </p>
                                        </td>
                                        <td class="">
                                            <p class="text-center text-xs font-weight-bold mb-0">
                                                {{ $data->total_pendapatan }}
                                            </p>
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
</div>