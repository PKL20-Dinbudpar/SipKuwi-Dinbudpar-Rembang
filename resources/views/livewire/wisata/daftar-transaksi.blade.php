<div class="container-fluid py-4">
    
    {{-- Tables --}}
    {{-- @include('components.tables.table') --}}
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                @if (session()->has('message'))
                    <div class=" d-flex flex-row alert alert-success mx-3 mb-0 justify-content-between" style="margin-top:30px;" x-data="{ show: true }" x-show="show">
                        <div >
                            {{ session('message') }}
                        </div>
                        <span @click=" show = false ">
                            <i class="fa fa-times" style="font-size:12px"></i>
                        </span>
                    </div>
                @endif
                <div class="card-header pb-0">
                    <div>
                        <h5 class="mb-3">Daftar Transaksi Hari Ini</h5>
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