<?php

namespace App\Http\Livewire;

use App\Models\Hotel;
use App\Models\User;
use App\Models\Wisata;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfile extends Component
{
    use WithFileUploads;
    
    public User $user;

    public $newPhoto;

    public $newPassword;
    public $newPasswordConfirmation;
    public $oldPassword;
    public $typePass = 'password';

    public $showSuccesNotification  = false;

    public $showDemoNotification = false;
    
    protected $rules = [
        'user.name' => 'max:40|min:3',
        'user.username' => 'max:40|min:3',
        'user.email' => 'email:rfc,dns',
        'user.phone' => 'max:10',
        'user.alamat' => 'max:200',
    ];

    public function mount() { 
        $this->user = auth()->user();
    }

    public function updatePhoto()
    {
        $this->validate([
            'newPhoto' => 'image|max:1024',
        ]);

        $photo = $this->newPhoto->store('photos', 'public');

        $this->user->photo = $photo;
        $this->user->save();
        return redirect()->route('user-profile');
    }

    public function save() {
        $this->validate();
        $this->user->save();
        $this->showSuccesNotification = true;
    }

    public function savePassword(){
        $this->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'newPasswordConfirmation' => 'required|same:newPassword',
        ]);
        if (Hash::check($this->newPassword, $this->user->password)) {
            $this->addError('newPassword', 'The new password must be different from the old password');
            return;
        }
        if ($this->newPasswordConfirmation != $this->newPassword) {
            $this->addError('newPasswordConfirmation', 'The new password confirmation does not match');
            return;
        }
        if (Hash::check($this->oldPassword, $this->user->password)) {
            $this->user->password = bcrypt($this->newPassword);
            $this->user->save();
            $this->showSuccesNotification = true;
            $this->emit('passwordSaved');
        } 
        else {
            $this->addError('oldPassword', 'The old password is incorrect');
        }
    }

    public function resetPass()
    {
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        $this->oldPassword = '';

        $this->resetErrorBag();
    }

    public function showPass()
    {
        if ($this->typePass == 'password') {
            $this->typePass = 'text';
        } else {
            $this->typePass = 'password';
        }
    }

    public function render()
    {
        if (auth()->user()->role == 'wisata'){
            $wisata = Wisata::where('id_wisata', auth()->user()->id_wisata)->first();

            return view('livewire.user-profile', compact('wisata'));

        } else if (auth()->user()->role == 'hotel'){
            $hotel = Hotel::where('id_hotel', auth()->user()->id_hotel)->first();

            return view('livewire.user-profile', compact('hotel'));

        } else {
            return view('livewire.user-profile');
        }
    }
}
