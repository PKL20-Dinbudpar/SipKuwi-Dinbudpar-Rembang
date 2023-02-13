<main class="main-content">
    <div class="container-fluid pt-0">
        {{-- Grafik Kunjungan Hotel Tahunan --}}
        <div class="row">
            <div class="col-12">
              <div class="card mb-4">
                <div class="card-header pb-0">
                    <div>
                        <h5>Grafik Kunjungan {{ $hotel->nama_hotel }}</h5>
                    </div>
                </div>
                <div class="card-body px-4 pt-0 pb-4">
                    {{-- Tahun Selector --}}
                    <div class="flex-row d-flex justify-content-between">
                        <div class="form-group col-lg-6 d-flex">
                            <select class="form-control" wire:model="tahun" id="tahun" name="tahun">
                                @for ($i = date('Y'); $i >= 2022; $i--)
                                    <option value="{{ $i }}" @selected(date('Y') == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex">
                            <button class="btn bg-gradient-success" wire:click="showGraph">
                                @if (!$showGraph)
                                    Tampilkan Grafik
                                @else
                                    Sembunyikan Grafik
                                @endif
                            </button>
                        </div>
                    </div>

                    {{-- Chart --}}
                    @if ($showGraph)    
                        <div class="shadow rounded p-4 border bg-white" style="height: 32rem;">
                            <livewire:livewire-line-chart
                                key="{{ $multiLineChartModel->reactiveKey() }}"
                                :line-chart-model="$multiLineChartModel"
                            />
                        </div>
                        <div class="shadow rounded p-4 border bg-white" style="height: 32rem;">
                            <livewire:livewire-column-chart
                                :column-chart-model="$columnChartModel"
                            />
                        </div>
                    @endif
                </div>
            </div>

    </div>
</main>