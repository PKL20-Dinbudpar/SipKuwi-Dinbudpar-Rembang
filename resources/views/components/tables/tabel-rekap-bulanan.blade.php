<table class="table align-items-center mb-0">
    <col>
    <col>
    @foreach ($tanggal as $hari)
        <colgroup span="3"></colgroup>
    @endforeach
    <col>
    <col>
    <thead>
        <tr>
            <th scope="col" rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                No
            </th>
            <th scope="col" rowspan="2" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                Nama Objek Wisata
            </th>
            @foreach ($tanggal as $hari)
                <th scope="col" colspan="3" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ $hari->tanggal->format('d M Y') }}
                </th>
            @endforeach
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Total Pengunjung
            </th>
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Total Pendapatan
            </th>
        </tr>
        <tr>
            @foreach ($tanggal as $hari)
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    WisNus
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    WisMan
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Pendapatan
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
            <th scope="row">
                <p class="text-xs font-weight-bold mb-0">
                    {{ $objek->nama_wisata }}
                </p>
                @php
                    $totalWisatawan = 0;
                    $totalPendapatan = 0;
                @endphp
            </th>
            @foreach ($rekap as $data)
                @foreach ($tanggal as $hari)    
                    @if ($data->id_wisata == $objek->id_wisata && $data->tanggal == $hari->tanggal)
                        @php
                            $totalWisatawan += $data->wisatawan_domestik + $data->wisatawan_mancanegara;
                            $totalPendapatan += $data->total_pendapatan;
                        @endphp
                        <td scope="row" class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_domestik ?? 0 }}</span>
                        </td>
                        <td scope="row" class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_mancanegara ?? 0 }}</span>
                        </td>
                        <td scope="row" class="align-middle text-center">
                            <span class="text-secondary text-xs font-weight-bold">{{ $data->total_pendapatan ?? 0 }}</span>
                        </td>
                    {{-- @elseif ($data->tanggal != $hari->tanggal)
                        <td></td>
                        <td></td>
                        <td></td> --}}
                    @endif
                @endforeach
            @endforeach
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalWisatawan == 0 ? 0 : $totalWisatawan }}
                </span>
            </td>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalPendapatan == 0 ? 0 : $totalPendapatan }}
                </span>
            </td>
        @endforeach
    </tbody>
</table>