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
                Nama Hotel
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
                Total Kamar Terjual
            </th>
        </tr>
        <tr>
            @foreach ($bulan as $bln)
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
                $totalWisatawan = 0;
                $totalKamarTerjual = 0;
            @endphp
        </th>
        @foreach ($bulan as $bln)
            @php
                $data = $rekap->where('id_hotel', $objek->id_hotel)->where('bulan', $bln->bulan)->first();
                
                if ($data) {
                    $totalWisatawan += $data->pengunjung_nusantara + $data->pengunjung_mancanegara;
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
                {{ number_format($totalWisatawan, 0, ',', '.') }}
            </span>
        </td>
        <td scope="row" class="align-middle text-center">
            <span class="text-secondary text-xs font-weight-bold">
                {{ number_format($totalKamarTerjual, 0, ',', '.') }}
            </span>
        </td>
        </tr>
        @endforeach
    </tbody>
</table>