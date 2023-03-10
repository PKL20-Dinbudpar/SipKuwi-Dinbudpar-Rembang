<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Metas -->
    @if(env('IS_DEMO'))
        <x-demo-metas></x-demo-metas>
    @endif
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/logorembang.png">
    <title>
        SIPKuWi Rembang
    </title>
    <!-- Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ url('assets/css/soft-ui-dashboard.css') }}">
    {{-- <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" /> --}}
    {{-- <link id="pagestyle" href="../assets/css/soft-ui-dashboard.css?v=1" rel="stylesheet" /> --}}
    <!-- Alpine -->
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles

    {{-- Apex Chart --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="g-sidenav-show bg-gray-100">

    {{ $slot }}

    <!--   Core JS Files   -->
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="assets/js/soft-ui-dashboard.js"></script>
    @livewireScripts
    @livewireChartsScripts

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        window.livewire.on('wisataSaved', () => {
            $('#createWisataModal').modal('hide');
        });

        window.livewire.on('wisataDeleted', () => {
            $('#deleteWisataModal').modal('hide');
        });
        window.livewire.on('userSaved', () => {
            $('#createUserModal').modal('hide');
        });
        window.livewire.on('userDeleted', () => {
            $('#deleteUserModal').modal('hide');
        });
        window.livewire.on('rekapSaved', () => {
            $('#editRekapModal').modal('hide');
        });
        window.livewire.on('rekapDeleted', () => {
            $('#deleteRekapModal').modal('hide');
        });
        window.livewire.on('tiketSaved', () => {
            $('#createTiketModal').modal('hide');
        });
        window.livewire.on('tiketDeleted', () => {
            $('#deleteTiketModal').modal('hide');
        });
        window.livewire.on('passwordSaved', () => {
            $('#changePassModal').modal('hide');
        });
        window.livewire.on('hotelSaved', () => {
            $('#createHotelModal').modal('hide');
        });
        window.livewire.on('hotelDeleted', () => {
            $('#deleteHotelModal').modal('hide');
        });
        window.livewire.on('transaksiSaved', () => {
            $('#createTransaksiModal').modal('hide');
        });
        window.livewire.on('transaksiDeleted', () => {
            $('#deleteTransaksiModal').modal('hide');
        });
        window.livewire.on('photoSaved', () => {
            $('#updateImgModal').modal('hide');
        });
    </script>
</body>

</html>
