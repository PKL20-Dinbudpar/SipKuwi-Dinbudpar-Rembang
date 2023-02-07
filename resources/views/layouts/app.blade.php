<x-layouts.base>
    {{-- If the user is authenticated --}}
    @auth()
        @include('layouts.navbars.auth.sidebar')
        @include('layouts.navbars.auth.nav')
        {{ $slot }}
        <main>
            <div class="container-fluid">
                <div class="row">
                    @include('layouts.footers.auth.footer')
                </div>
            </div>
        </main>
    @endauth

    {{-- If the user is not authenticated (if the user is a guest) --}}
    @guest
        {{-- If the user is on the login page --}}
        @if (!auth()->check() && in_array(request()->route()->getName(),['login'],))
            {{ $slot }}
        @else
            @include('layouts.navbars.guest.nav')
            @include('layouts.navbars.auth.sidebar')
            {{ $slot }}
            <main>
                <div class="container-fluid">
                    <div class="row">
                        @include('layouts.footers.auth.footer')
                    </div>
                </div>
            </main>
        @endif
    @endguest
</x-layouts.base>
