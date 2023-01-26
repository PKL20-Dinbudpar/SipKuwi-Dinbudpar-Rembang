<main class="main-content">
    <div class="container-fluid pt-0">
        <div class="row mt-0">
            {{-- Link to Halaman Rekap Tahunan --}}
            <div class="d-flex justify-content-start mb-3 text-center">
                <a type="button" class="btn bg-gradient-secondary w-auto mt-4 mb-0 
                {{ Route::currentRouteName() == 'home-dinas' ? 'active' : '' }}"
                href="{{ route('home-dinas') }}">
                    {{ __('Bulanan') }}
                </a>
                <a type="button" class="btn bg-gradient-info w-auto mx-2 mt-4 mb-0 {{ Route::currentRouteName() == 'home-dinas' ? 'active' : '' }}">{{ __('Tahunan') }}</a>
            </div>
        </div>

        {{-- Bulan dan Tahun Selector --}}
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Pilih Bulan dan Tahun</h6>
                    </div>
                    <div class="card-body px-4 pt-0 pb-2">
                        {{-- Dropdown select Bulan and Tahun --}}
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="bulan">Bulan</label>
                                <select class="form-control" wire:model="bulan" id="bulan" name="bulan">
                                    <option>Pilih Bulan</option>
                                    <option value="01" @selected(date('m') == 1)>Januari</option>
                                    <option value="02" @selected(date('m') == 2)>Februari</option>
                                    <option value="03" @selected(date('m') == 3)>Maret</option>
                                    <option value="04" @selected(date('m') == 4)>April</option>
                                    <option value="05" @selected(date('m') == 5)>Mei</option>
                                    <option value="06" @selected(date('m') == 6)>Juni</option>
                                    <option value="07" @selected(date('m') == 7)>Juli</option>
                                    <option value="08" @selected(date('m') == 8)>Agustus</option>
                                    <option value="09" @selected(date('m') == 9)>September</option>
                                    <option value="10" @selected(date('m') == 10)>Oktober</option>
                                    <option value="11" @selected(date('m') == 11)>November</option>
                                    <option value="12" @selected(date('m') == 12)>Desember</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tahun">Tahun</label>
                                <select class="form-control" wire:model="tahun" id="tahun" name="tahun">
                                    <option>Pilih Tahun</option>
                                    @for ($i = date('Y'); $i >= 2021; $i--)
                                        <option value="{{ $i }}" @selected(date('Y') == $i)>{{ $i }}</option>
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
                            <h5>Rekap Data Bulanan</h5>
                        </div>
                        <button wire:click.prevent="export" class="btn bg-gradient-success btn-sm mb-0"><i class="fa fa-file-excel-o" style="font-size:12px"></i> Export Excel</button>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if ($rekap->count() > 0)
                        <div class="table-responsive p-0">
                            @include('components.tables.tabel-rekap-bulanan')
                        </div>
                    @else
                        @if ($bulan != "" && $tahun != "")
                            <div class="text-center m-5">
                                <p class="text-gray-500">Tidak ada Data</p>
                            </div>
                        @endif
                    @endif
                </div>
              </div>
            </div>
        </div>
    </div>
</main>
