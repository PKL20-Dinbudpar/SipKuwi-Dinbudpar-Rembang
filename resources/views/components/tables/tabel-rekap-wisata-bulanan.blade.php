<table class="table table-hover table-sticky align-items-center mb-0">
    <col>
    <col>
    @foreach ($bulan as $bln)
        <colgroup span="3"></colgroup>
    @endforeach
    <col>
    <col>
    <thead>
        <tr>
            <th scope="col" rowspan="2" class="text-center text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                No
            </th>
            <td scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ps-2">
                Nama Objek Wisata
            </td>
            @foreach ($bulan as $bln)
                <th scope="col" colspan="3" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
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
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Total Pendapatan
            </th>
        </tr>
        <tr>
            @foreach ($bulan as $bln)
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
        <th scope="row" class="align-items-center">
            <a href="/edit-rekap-wisata:{{ $objek->id_wisata }}" class="d-flex justify-content-left">
                <i class="mx-3 cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                <p class="text-xs font-weight-bold mb-0">
                    {{ $objek->nama_wisata }}
                </p>
            </a>
            @php
                $totalWisatawan = 0;
                $totalPendapatan = 0;
            @endphp
        </th>
        @foreach ($bulan as $bln)
            @php
                $data = $rekap->where('id_wisata', $objek->id_wisata)->where('bulan', $bln->bulan)->first();
                
                if ($data) {
                    $totalWisatawan += $data->wisatawan_nusantara + $data->wisatawan_mancanegara;
                    $totalPendapatan += $data->total_pendapatan;
                }
            @endphp

            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    @isset($data->wisatawan_nusantara)
                        {{ number_format($data->wisatawan_nusantara, 0, ',', '.')}}
                    @endisset
                </span>
            </td>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    @isset($data->wisatawan_mancanegara)
                        {{ number_format($data->wisatawan_mancanegara, 0, ',', '.')}}
                    @endisset
                </span>
            </td>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    @isset($data->total_pendapatan)
                        Rp {{ number_format($data->total_pendapatan, 0, ',', '.')}}
                    @endisset
                </span>
            </td>
        @endforeach
        <td scope="row" class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">
                {{ $totalWisatawan == 0 ? 0 : number_format($totalWisatawan, 0, ',', '.')}}
            </span>
        </td>
        <td scope="row" class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">
                Rp {{ $totalPendapatan == 0 ? 0 : number_format($totalPendapatan, 0, ',', '.')}}
            </span>
        </td>
        </tr>
        @endforeach
    </tbody>
</table>