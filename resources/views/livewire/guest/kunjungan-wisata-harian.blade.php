<main class="main-content">
    <div class="container-fluid pt-0">
        <div class="row mt-0">
            {{-- Link to Halaman Rekap Tahunan --}}
            <div class="d-flex justify-content-start mb-3 text-center">
                <a type="button" class="btn bg-gradient-info w-auto mt-4 mb-0 
                {{ Route::currentRouteName() == 'kunjungan-wisata-harian' ? 'active' : '' }}"
                href="{{ route('kunjungan-wisata-harian') }}">
                    {{ __('Harian') }}
                </a>
                <a type="button" class="btn bg-gradient-secondary w-auto mx-2 mt-4 mb-0 
                {{ Route::currentRouteName() == 'kunjungan-wisata-bulanan' ? 'active' : '' }}"
                href="{{ route('kunjungan-wisata-bulanan') }}">
                    {{ __('Bulanan') }}
                </a>
            </div>
        </div>

        {{-- Bulan dan Tahun Selector --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        {{-- <h6>Pilih Bulan dan Tahun</h6> --}}
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        {{-- Dropdown select Bulan and Tahun --}}
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" wire:model="bulan" id="bulan" name="bulan">
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
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" wire:model="tahun" id="tahun" name="tahun">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>

        {{-- Tabel --}}
        <div class="row">
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5>Rekap Kunjungan Wisata Harian 
                                @if ($bulan != "" && $tahun != "")
                                    {{ $bulan == '01' ? 'Januari' : '' }}
                                    {{ $bulan == '02' ? 'Februari' : '' }}
                                    {{ $bulan == '03' ? 'Maret' : '' }}
                                    {{ $bulan == '04' ? 'April' : '' }}
                                    {{ $bulan == '05' ? 'Mei' : '' }}
                                    {{ $bulan == '06' ? 'Juni' : '' }}
                                    {{ $bulan == '07' ? 'Juli' : '' }}
                                    {{ $bulan == '08' ? 'Agustus' : '' }}
                                    {{ $bulan == '09' ? 'September' : '' }}
                                    {{ $bulan == '10' ? 'Oktober' : '' }}
                                    {{ $bulan == '11' ? 'November' : '' }}
                                    {{ $bulan == '12' ? 'Desember' : '' }}
                                    {{ $tahun }}
                                @endif
                            </h5>
                        </div>
                        {{-- <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm mb-0"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button> --}}
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if ($tahun < date('Y') || ($tahun == date('Y') && $bulan <= date('m')))
                        <div class="table-responsive p-0">
                            <table class="table table-hover align-items-center mb-0">
                                <col>
                                <col>
                                @foreach ($tanggal as $tgl)
                                    <colgroup span="2"></colgroup>
                                @endforeach
                                <col>
                                <col>
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Objek Wisata
                                        </th>
                                        @foreach ($tanggal as $tgl)
                                            <th scope="col" colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{ $tgl->tanggal->format('d M Y') }}
                                            </th>
                                        @endforeach
                                        <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Pengunjung
                                        </th>
                                    </tr>
                                    <tr>
                                        @foreach ($tanggal as $tgl)
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                WisNus
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                WisMan
                                            </th>
                                        @endforeach 
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wisata as $objek)
                                        <tr>
                                        <td scope="row" class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                        </td>
                                        <th scope="row" class="align-items-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $objek->nama_wisata }}
                                            </p>
                                            @php
                                                $totalWisatawan = 0;
                                            @endphp
                                        </th>
                                        @foreach ($tanggal as $tgl)
                                            @php
                                                $data = $rekap->where('id_wisata', $objek->id_wisata)->where('tanggal', $tgl->tanggal)->first();
                            
                                                if ($data) {
                                                    $totalWisatawan += $data->wisatawan_nusantara + $data->wisatawan_mancanegara;
                                                }
                                            @endphp
                                            <td scope="row" class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_nusantara ?? "" }}</span>
                                            </td>
                                            <td scope="row" class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_mancanegara ?? "" }}</span>
                                            </td>

                                        @endforeach
                                        <td scope="row" class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $totalWisatawan == 0 ? 0 : $totalWisatawan }}
                                            </span>
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center m-5">
                            <p class="text-gray-500">Belum ada data</p>
                        </div>
                    @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</main>
