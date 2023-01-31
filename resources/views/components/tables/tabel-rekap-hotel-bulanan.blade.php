<table class="table table-hover align-items-center mb-0">
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
            <th scope="col" rowspan="2" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                Nama Hotel
            </th>
            @foreach ($tanggal as $tgl)
                <th scope="col" colspan="3" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    {{ $tgl->tanggal->format('d M Y') }}
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
            @foreach ($tanggal as $tgl)
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
        @foreach ($hotel as $objek)
            <tr>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
            </td>
            <th scope="row" class="align-items-center">
                {{-- <a href="/edit-rekap-hotel{{ $objek->id_hotel }}" class="d-flex justify-content-left"> --}}
                    <i class="mx-3 cursor-pointer fas fa-pencil-alt text-secondary" aria-hidden="true"></i>
                    <p class="text-xs font-weight-bold mb-0">
                        {{ $objek->nama_hotel }}
                    </p>
                {{-- </a> --}}
                @php
                    $totalPengunjung = 0;
                    $totalPendapatan = 0;
                @endphp
            </th>
            @foreach ($tanggal as $tgl)
                @php
                    $data = $rekap->where('id_hotel', $objek->id_hotel)->where('tanggal', $tgl->tanggal)->first();

                    if ($data) {
                        $totalPengunjung += $data->wisatawan_domestik + $data->wisatawan_mancanegara;
                        $totalPendapatan += $data->total_pendapatan;
                    }
                @endphp
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_domestik ?? "" }}</span>
                </td>
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $data->wisatawan_mancanegara ?? "" }}</span>
                </td>
                <td scope="row" class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ $data->total_pendapatan ?? "" }}</span>
                </td>
            @endforeach
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalPengunjung == 0 ? 0 : $totalPengunjung }}
                </span>
            </td>
            <td scope="row" class="align-middle text-center">
                <span class="text-secondary text-xs font-weight-bold">
                    {{ $totalPendapatan == 0 ? 0 : $totalPendapatan }}
                </span>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>