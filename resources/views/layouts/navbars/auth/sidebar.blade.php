<aside style="height: screen" class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 mh-100"
    id="sidenav-main">
    <div class="sidenav-header">
        @if (Auth::user())
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
                aria-hidden="true" id="iconSidenav"></i>
            <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('home') }}">
                <img src="../assets/img/logorembang.png" class="navbar-brand-img h-100" alt="...">
                <span class="ms-3 font-weight-bold">SIPKuWi Rembang</span>
            </a>
        @endif
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            @if (Auth::user()->role == 'dinas')
                <x-side-nav-dinas />
            @elseif (Auth::user()->role == 'wisata')
                <x-side-nav-wisata />
            @elseif (Auth::user()->role == 'hotel')
                <x-side-nav-hotel />
            @endif
        </ul>
    </div>
    <div class="sidenav-footer mx-3 mt-3 pt-3">
        <div class="card card-background shadow-none 
            @if (Auth::user()->role == 'dinas')
                card-background-mask-danger 
            @elseif (Auth::user()->role == 'wisata')
                card-background-mask-info 
            @elseif (Auth::user()->role == 'hotel')
                card-background-mask-secondary 
            @endif 
        mb-2" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpeg')">
            </div>
            <div class="card-body text-left p-2 pb-0 w-100">
                <div class="docs-info">
                    <h6 class="text-white up mb-0">{{ Auth::user()->name }}</h6>
                    <p class="text-xs font-weight-bold">
                        @if (Auth::user()->role == 'dinas')
                            Dinbudpar Rembang
                        @elseif (Auth::user()->role == 'wisata')
                            {{ Auth::user()->wisata->nama_wisata }}
                        @elseif (Auth::user()->role == 'hotel')
                            {{ Auth::user()->hotel->nama_hotel }}
                        @endif 
                    </p>
                </div>
            </div>
        </div>
        <div class="card card-background shadow-none card-background-mask-primary" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpeg')">
            </div>
            <div class="card-body text-left p-3 w-100">
                {{-- <div
                    class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true"
                        id="sidenavCardIcon"></i>
                </div> --}}
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Butuh Bantuan?</h6>
                    <p class="text-xs font-weight-bold">Hubungi Dinbudpar Rembang</p>
                    <a href="https://dinbudpar.rembangkab.go.id/hubungi-kami/" target="_blank"
                        class="btn btn-white btn-sm w-100 mb-0">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</aside>
