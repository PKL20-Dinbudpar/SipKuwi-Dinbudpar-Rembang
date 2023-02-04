<main class="main-content">
    <div class="container-fluid pt-0">
        <div class="row mt-0">
            {{-- Link to Halaman Rekap Tahunan --}}
            <div class="d-flex justify-content-start mb-3 text-center">
                <a type="button" class="btn bg-gradient-secondary w-auto mt-4 mb-0 
                {{ Route::currentRouteName() == 'rekap-wisata-harian' ? 'active' : '' }}"
                href="{{ route('rekap-wisata-harian') }}">
                    {{ __('Harian') }}
                </a>
                <a type="button" class="btn bg-gradient-info w-auto mx-2 mt-4 mb-0 
                {{ Route::currentRouteName() == 'rekap-wisata-bulanan' ? 'active' : '' }}"
                href="{{ route('rekap-wisata-bulanan') }}">
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
                                    <option>Pilih Tahun</option>
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
                        <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm mb-0"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if ($rekap->count() > 0)
                        <div class="table-responsive p-0">
                            @include('components.tables.tabel-rekap-wisata-bulanan')
                        </div>
                    @elseif ($tahun != "")
                        <div class="text-center m-5">
                            <p class="text-gray-500">Tidak ada data</p>
                        </div>
                    @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</main>