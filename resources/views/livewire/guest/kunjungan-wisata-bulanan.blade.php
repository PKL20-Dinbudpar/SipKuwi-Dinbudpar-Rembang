<main class="main-content">
    <div class="container-fluid pt-0">
        <div class="row mt-0">
            {{-- Link to Halaman Rekap Tahunan --}}
            <div class="d-flex justify-content-start mb-3 text-center">
                <a type="button" class="btn bg-gradient-secondary w-auto mt-4 mb-0 
                {{ Route::currentRouteName() == 'kunjungan-wisata-harian' ? 'active' : '' }}"
                href="{{ route('kunjungan-wisata-harian') }}">
                    {{ __('Harian') }}
                </a>
                <a type="button" class="btn bg-gradient-info w-auto mx-2 mt-4 mb-0 
                {{ Route::currentRouteName() == 'kunjungan-wisata-bulanan' ? 'active' : '' }}"
                href="{{ route('kunjungan-wisata-bulanan') }}">
                    {{ __('Bulanan') }}
                </a>
            </div>
        </div>

        {{-- Tahun Selector --}}
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
                                <label for="tahun">Tahun</label>
                                <select class="form-control" wire:model="tahun" id="tahun" name="tahun">
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option value="{{ $i }}" @selected(date('Y') == $i)>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>

        {{-- Tabel Rekap Tahunan --}}
        <div class="row">
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5>Rekap Kunjungan Wisata Bulanan
                                @if ($tahun != "")
                                    {{ $tahun }}
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if ($tahun <= date('Y'))
                        <div class="table-responsive p-0">
                            <table class="table table-hover align-items-center mb-0">
                                <col>
                                <col>
                                @foreach ($bulan as $bln)
                                    <colgroup span="2"></colgroup>
                                @endforeach
                                <col>
                                <col>
                                <thead>
                                    <tr>
                                        <th scope="col" rowspan="2" class="text-center text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Objek Wisata
                                        </th>
                                        @foreach ($bulan as $bln)
                                            <th scope="col" colspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                @if ($bln->bulan == "1")
                                                    {{ "Januari" }}
                                                @elseif($bln->bulan == "2")
                                                    {{ "Februari" }}
                                                @elseif($bln->bulan == "3")
                                                    {{ "Maret" }}
                                                @elseif($bln->bulan == "4")
                                                    {{ "April" }}
                                                @elseif($bln->bulan == "5")
                                                    {{ "Mei" }}
                                                @elseif($bln->bulan == "6")
                                                    {{ "Juni" }}
                                                @elseif($bln->bulan == "7")
                                                    {{ "Juli" }}
                                                @elseif($bln->bulan == "8")
                                                    {{ "Agustus" }}
                                                @elseif($bln->bulan == "9")
                                                    {{ "September" }}
                                                @elseif($bln->bulan == "10")
                                                    {{ "Oktober" }}
                                                @elseif($bln->bulan == "11")
                                                    {{ "November" }}
                                                @elseif($bln->bulan == "12")
                                                    {{ "Desember" }}
                                                @endif
                                            </th>
                                        @endforeach
                                        <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Pengunjung
                                        </th>
                                    </tr>
                                    <tr>
                                        @foreach ($bulan as $bln)
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Nusantara
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
                                    @foreach ($bulan as $bln)
                                        @php
                                            $data = $rekap->where('id_wisata', $objek->id_wisata)->where('bulan', $bln->bulan)->first();
                                            
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