<main class="main-content mt-1 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
        navbar-scroll="true">
        <div class="container-fluid py-1 px-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                    <li class="breadcrumb-item text-md"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
                    </li>
                    <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">
                        {{ str_replace('-', ' ', Route::currentRouteName()) }}</li>
                </ol>
                <h6 class="font-weight-bolder mb-0 text-capitalize">
                    {{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
            </nav>
            <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
                <ul class="navbar-nav justify-content-between">
                    <li class="nav-item d-xl-none px-3 d-flex align-items-center">
                        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item dropdown mt-3 d-flex align-items-center">
                        {{-- Redirect link to login but in other page --}}
                        <a href="{{ route('login') }}" class="btn btn-sm bg-gradient-success" target="_blank">Login</a>


                        {{-- <a href="javascript:;" class="nav-link text-body p-0 mt-1" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ni ni-circle-08 me-sm-1 mr-2"></i>
                            <i class="ni ni-bold-down"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="{{ route('user-profile') }}">
                                    <div class="d-flex py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <i class="fa fa-user me-sm-1 mr-2"></i>
                                                <span class="font-weight-bold d-inline">Profile</span>
                                            </h6>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="mb-2">
                                <livewire:auth.logout />
                            </li>
                        </ul> --}}
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
