<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;

class Login extends Component
{
    public $auth = '';
    public $password = '';
    public $remember_me = false;

    protected $rules = [
        'auth' => 'required|string',
        'password' => 'required',
    ];

    public function mount() {
        if(auth()->user()){
            redirect('/');
        }
    }

    public function login() {
        $credentials = $this->validate();
        if(auth()->attempt(['username' => $this->auth,  'password' => $this->password], $this->remember_me)) {
            $user = AuthUser::where(["username" => $this->auth])
                ->first();
            auth()->login($user, $this->remember_me);
            return redirect()->intended('/');        
        }
        else{
            return $this->addError('auth', trans('auth.failed')); 
        }
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
