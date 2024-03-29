<section>
    <div class="page-header section-height-">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                    <div class="card card-plain mt-8">
                        <div class="card-image d-flex justify-content-center">
                            <img src="../assets/img/logorembang.png" class="card-image h-20 w-20"></div>
                        <div class="card-header pb-0 text-center bg-transparent">
                            <p class="mb-0">{{ __('Sistem Informasi Pendataan Kunjungan Wisata')}}<br></p>
                            <p class="mb-0">{{__('Kabupaten Rembang') }}</p>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="login" action="#" method="POST" role="form text-left">
                                @error('auth') <div class="text-danger">{{ $message }}</div> @enderror
                                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                <div class="mb-3">
                                    <label for="email">{{ __('Username') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <input wire:model="auth" id="auth" type="text" class="form-control"
                                            placeholder="Username" aria-label="Email" aria-describedby="email-addon">
                                    </div>
                                    {{-- @error('email') <div class="text-danger">{{ $message }}</div> @enderror --}}
                                </div>
                                <div class="mb-3">
                                    <label for="password">{{ __('Password') }}</label>
                                    <div class="@error('password')border border-danger rounded-3 @enderror">
                                        <input wire:model="password" id="password" type="password" class="form-control"
                                            placeholder="Password" aria-label="Password"
                                            aria-describedby="password-addon">
                                    </div>
                                </div>
                                <div class="form-check form-switch">
                                    <input wire:model="remember_me" class="form-check-input" type="checkbox"
                                        id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">{{ __('Ingat Saya') }}</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit"
                                        class="btn bg-gradient-info w-100 mt-4 mb-0">{{ __('Sign in') }}</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <small class="text-muted">{{ __('Lupa password anda? Reset password anda') }} <a
                                    href="{{ route('forgot-password') }}"
                                    class="text-info text-gradient font-weight-bold">{{ __('disini') }}</a></small>
                            <br>
                            <small class="text-muted">{{ __('Belum punya akun?') }} <a
                                href="https://dinbudpar.rembangkab.go.id/hubungi-kami/"
                                class="text-info text-gradient font-weight-bold">{{ __('Hubungi kami') }}</a></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                        {{-- <img src="../assets/img/enjoyRembang.jpeg" alt="" class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"> --}}
                        <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                            style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
