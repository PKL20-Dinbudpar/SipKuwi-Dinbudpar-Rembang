<table class="table table-hover table-sticky align-items-center mb-0">
    <col>
    <col>
    @foreach ($tanggal as $tgl)
        <colgroup span="3"></colgroup>
    @endforeach
    <col>
    <col>
    <thead>
        <tr>
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                No
            </th>
            <td scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                Nama Hotel
            </td>
            @foreach ($tanggal as $tgl)
                <th scope="col" colspan="3" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ $tgl->tanggal->format('d M Y') }}
                </th>
            @endforeach
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Total Pengunjung
            </th>
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Total Kamar Terjual
            </th>
        </tr>
        <tr>
            @foreach ($tanggal as $tgl)
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Nusantara
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Manca
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Kamar Terjual
                </th>
            @endforeach 
        </tr>
    </thead>
    <tbody>
        @foreach ($hotel as $objek)
            <tr>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
            </td>
            <th scope="row" class="align-items-center">
                <a href="/edit-rekap-hotel:{{ $objek->id_hotel }}" class="d-flex justify-content-left">
                    <i class="mx-3 cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                    <p class="text-xs font-weight-bold mb-0">
                        {{ $objek->nama_hotel }}
                    </p>
                </a>
                @php
                    $totalPengunjung = 0;
                    $totalKamarTerjual = 0;
                @endphp
            </th>
            @foreach ($tanggal as $tgl)
                @php
                    $data = $rekap->where('id_hotel', $objek->id_hotel)->where('tanggal', $tgl->tanggal)->first();

                    if ($data) {
                        $totalPengunjung += $data->pengunjung_nusantara + $data->pengunjung_mancanegara;
                        $totalKamarTerjual += $data->kamar_terjual;
                    }
                @endphp
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                        @isset($data->pengunjung_nusantara)
                            {{ number_format($data->pengunjung_nusantara, 0, ',', '.')}}
                        @endisset
                    </span>
                </td>
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                        @isset($data->pengunjung_mancanegara)
                            {{ number_format($data->pengunjung_mancanegara, 0, ',', '.')}}
                        @endisset
                    </span>
                </td>
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">
                        @isset($data->kamar_terjual)
                            {{ number_format($data->kamar_terjual, 0, ',', '.')}}
                        @endisset
                    </span>
                </td>
            @endforeach
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalPengunjung == 0 ? 0 : number_format($totalPengunjung, 0, ',', '.')}}
                </span>
            </td>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalKamarTerjual == 0 ? 0 : number_format($totalKamarTerjual, 0, ',', '.')}}
                </span>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>