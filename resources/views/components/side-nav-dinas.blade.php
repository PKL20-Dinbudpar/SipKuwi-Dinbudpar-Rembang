<li class="nav-item pb-2">
    <a class="nav-link {{ Route::currentRouteName() == 'rekap-wisata-harian' || Route::currentRouteName() == 'rekap-wisata-bulanan' ? 'active' : '' }}"
        href="{{ route('rekap-wisata-harian') }}">
        <div
            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>document</title>
                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Rounded-Icons" transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                        fill-rule="nonzero">
                        <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                            <g id="document" transform="translate(154.000000, 300.000000)">
                                <path class="color-background"
                                    d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                    id="Path" opacity="0.603585379"></path>
                                <path class="color-background"
                                    d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"
                                    id="Shape"></path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <span class="nav-link-text ms-1">Rekap Kujungan Wisata</span>
    </a>
</li>

<li class="nav-item pb-2">
    <a class="nav-link {{ Route::currentRouteName() == 'rekap-hotel-harian' || Route::currentRouteName() == 'rekap-hotel-harian' ? 'active' : '' }}"
        href="{{ route('rekap-hotel-harian') }}">
        <div
            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>document</title>
                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Rounded-Icons" transform="translate(-1870.000000, -591.000000)" fill="#FFFFFF"
                        fill-rule="nonzero">
                        <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                            <g id="document" transform="translate(154.000000, 300.000000)">
                                <path class="color-background"
                                    d="M40,40 L36.3636364,40 L36.3636364,3.63636364 L5.45454545,3.63636364 L5.45454545,0 L38.1818182,0 C39.1854545,0 40,0.814545455 40,1.81818182 L40,40 Z"
                                    id="Path" opacity="0.603585379"></path>
                                <path class="color-background"
                                    d="M30.9090909,7.27272727 L1.81818182,7.27272727 C0.814545455,7.27272727 0,8.08727273 0,9.09090909 L0,41.8181818 C0,42.8218182 0.814545455,43.6363636 1.81818182,43.6363636 L30.9090909,43.6363636 C31.9127273,43.6363636 32.7272727,42.8218182 32.7272727,41.8181818 L32.7272727,9.09090909 C32.7272727,8.08727273 31.9127273,7.27272727 30.9090909,7.27272727 Z M18.1818182,34.5454545 L7.27272727,34.5454545 L7.27272727,30.9090909 L18.1818182,30.9090909 L18.1818182,34.5454545 Z M25.4545455,27.2727273 L7.27272727,27.2727273 L7.27272727,23.6363636 L25.4545455,23.6363636 L25.4545455,27.2727273 Z M25.4545455,20 L7.27272727,20 L7.27272727,16.3636364 L25.4545455,16.3636364 L25.4545455,20 Z"
                                    id="Shape"></path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <span class="nav-link-text ms-1">Rekap Kujungan Hotel</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Route::currentRouteName() == 'daftar-wisata' ? 'active' : '' }}"
        href="{{ route('daftar-wisata') }}">
        <div
            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>office</title>
                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Rounded-Icons" transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                        fill-rule="nonzero">
                        <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                            <g id="office" transform="translate(153.000000, 2.000000)">
                                <path class="color-background"
                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"
                                    id="Path" opacity="0.6"></path>
                                <path class="color-background"
                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"
                                    id="Shape"></path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <span class="nav-link-text ms-1">Daftar Wisata</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Route::currentRouteName() == 'daftar-hotel' ? 'active' : '' }}"
        href="{{ route('daftar-hotel') }}">
        <div
            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <title>office</title>
                <g id="Basic-Elements" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Rounded-Icons" transform="translate(-1869.000000, -293.000000)" fill="#FFFFFF"
                        fill-rule="nonzero">
                        <g id="Icons-with-opacity" transform="translate(1716.000000, 291.000000)">
                            <g id="office" transform="translate(153.000000, 2.000000)">
                                <path class="color-background"
                                    d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"
                                    id="Path" opacity="0.6"></path>
                                <path class="color-background"
                                    d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,38.5 L19.25,38.5 L19.25,22.75 C19.25,21.78225 18.46775,21 17.5,21 L1.75,21 C0.78225,21 0,21.78225 0,22.75 L0,40.25 C0,41.21775 0.78225,42 1.75,42 L40.25,42 C41.21775,42 42,41.21775 42,40.25 L42,15.75 C42,14.78225 41.21775,14 40.25,14 Z M12.25,36.75 L7,36.75 L7,33.25 L12.25,33.25 L12.25,36.75 Z M12.25,29.75 L7,29.75 L7,26.25 L12.25,26.25 L12.25,29.75 Z M35,36.75 L29.75,36.75 L29.75,33.25 L35,33.25 L35,36.75 Z M35,29.75 L29.75,29.75 L29.75,26.25 L35,26.25 L35,29.75 Z M35,22.75 L29.75,22.75 L29.75,19.25 L35,19.25 L35,22.75 Z"
                                    id="Shape"></path>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <span class="nav-link-text ms-1">Daftar Hotel</span>
    </a>
</li>

<li class="nav-item pb-2">
    <a class="nav-link {{ Route::currentRouteName() == 'daftar-user' ? 'active' : '' }}"
        href="{{ route('daftar-user') }}">
        <div
            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
            <i style="font-size: 1rem;" class="fas fa-lg fa-list-ul ps-2 pe-2 text-center
            {{ in_array(request()->route()->getName(),['daftar-user']) ? 'text-white' : 'text-dark' }}"></i>
        </div>
        <span class="nav-link-text ms-1">Daftar User</span>
    </a>
</li>