<div>
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        @if (auth()->user()->photo)
                            <img src="{{ Storage::url(auth()->user()->photo) }}" alt="..." class="w-100 border-radius-lg shadow-sm">
                        @else
                            @if (auth()->user()->role == 'dinas')
                                <img src="{{ asset('assets/img/logoRembang.jpeg') }}" alt="..." class="w-100 border-radius-lg shadow-sm">
                            @else
                                <img src="{{ asset('assets/img/enjoyRembang.jpeg') }}" alt="..." class="w-100 border-radius-lg shadow-sm">
                            @endif
                        @endif
                        <button wire:click="resetPass" data-bs-toggle="modal" data-bs-target="#updateImgModal"
                            class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                            <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit Photo"></i>
                        </button>
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ auth()->user()->name }}
                        </h5>
                        <p class="mb-0 font-weight-bold text-sm">
                            @if (auth()->user()->role == 'dinas')
                                {{ __('Dinas Kebudayaan dan Pariwisata Rembang') }}
                            @elseif(auth()->user()->role == 'wisata')
                                {{ $wisata->nama_wisata ?? 'Objek Wisata' }}
                            @elseif(auth()->user()->role == 'hotel')
                                {{ $hotel->nama_hotel ?? 'Hotel' }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Informasi Profil') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">

                @if ($showSuccesNotification)
                    <div wire:model="showSuccesNotification"
                        class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                        <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                        <span
                            class="alert-text text-white">{{ __('Profil anda telah tersimpan!') }}</span>
                        <button wire:click="$set('showSuccesNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            X
                        </button>
                    </div>
                @endif

                <form wire:submit.prevent="save" action="#" method="POST" role="form text-left">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-name" class="form-control-label">{{ __('Nama Pengguna') }}</label>
                                <div class="@error('user.name')border border-danger rounded-3 @enderror">
                                    <input wire:model="user.name" class="form-control" type="text" placeholder="Nama"
                                        id="user-name">
                                </div>
                                @error('user.name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-username" class="form-control-label">{{ __('Username') }}</label>
                                <div class="@error('user.username')border border-danger rounded-3 @enderror">
                                    <input wire:model="user.username" class="form-control" type="username"
                                        placeholder="@example.com" id="user-username">
                                </div>
                                @error('user.username') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user-email" class="form-control-label">{{ __('Email') }}</label>
                                <div class="@error('user.email')border border-danger rounded-3 @enderror">
                                    <input wire:model="user.email" class="form-control" type="email"
                                        placeholder="@example.com" id="user-email">
                                </div>
                                @error('user.email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.phone" class="form-control-label">{{ __('Kontak') }}</label>
                                <div class="@error('user.phone')border border-danger rounded-3 @enderror">
                                    <input wire:model="user.phone" class="form-control" type="tel"
                                        placeholder="08xxxxxxxxxx" id="phone">
                                </div>
                                @error('user.phone') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alamat">{{ 'Alamat' }}</label>
                                <div class="@error('user.alamat')border border-danger rounded-3 @enderror">
                                    <textarea 
                                    wire:model="user.alamat" 
                                    class="form-control" id="alamat" rows="3"
                                        placeholder="Alamat rumah pengguna"></textarea>
                                </div>
                                @error('user.alamat') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user.pass" class="form-control-label">{{ __('Password') }}</label>
                                <div class="@error('user.password')border border-danger rounded-3 @enderror">
                                    <button wire:click="resetPass" type="button" data-bs-toggle="modal" data-bs-target="#changePassModal" 
                                        class="btn bg-gradient-danger btn-sm mt-2">{{ 'Ganti Password' }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Simpan Profil' }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- Modal Ganti Password --}}
    <x-modal> 
        <x-slot name="id"> changePassModal </x-slot>
        <x-slot name="title">
            Ganti Password
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="savePassword">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" wire:model.defer="newPassword" class="form-control">
                        @error('newPassword')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" wire:model.defer="newPasswordConfirmation" class="form-control">
                        @error('newPasswordConfirmation')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input type="password" wire:model.defer="oldPassword" class="form-control">
                        @error('oldPassword')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                </div>
            </form>
        </x-slot>
    </x-modal>

    {{-- Modal Update Photo --}}
    <x-modal>
        <x-slot name="id"> updateImgModal </x-slot>
        <x-slot name="title">
            Upload Gambar
        </x-slot>

        <x-slot name="content">
            <form wire:submit.prevent="updatePhoto">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Upload Gambar</label>
                        @if ($newPhoto)
                            <div class="d-flex">
                                <label for="photo" class="d-flex align-items-center">Preview:&nbsp;</label>
                                <div class="d-flex justify-content-center mb-2">
                                    <img src="{{ $newPhoto->temporaryUrl() }}" alt="" class="img-thumbnail" width="100px" height="100px">
                                </div>
                            </div>
                        @endif
                        <input type="file" wire:model="newPhoto" name="photo" class="form-control" placeholder="photo">
                        @error('newPhoto')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>
