<?php

namespace App\Livewire\Auth;

use App\Helpers\RedirectHelper;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterPage extends Component
{
    public $name, $first_name, $last_name, $email, $email_confirmation;
    public $password, $password_confirmation;
    public $agree_terms = false;
    public $create_account = false;

    public string $redirect_url = '/';

    protected $listeners = ['modalClosed' => 'resetForm'];

    public function mount()
    {
        $this->redirect_url = url()->current();
    }


    public function register()
    {
        //dd($this->last_name);
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|confirmed|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'agree_terms' => 'accepted',
            'create_account' => 'accepted',
        ]);

        $user = User::create([
            'name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'agreed_privacy_terms' => $this->agree_terms,
            'wants_account_creation' => $this->create_account,
        ]);

        Auth::login($user); // Log the user in immediately after registration

        //return redirect()->intended(session('url.intended', route('home'))); // Or any fallback
        //return redirect()->intended(route('home'));

        $safeUrl = RedirectHelper::validate($this->redirect_url);
        return redirect($safeUrl);
    }



    public function resetForm()
    {

        //logger('Modal closed, resetting form...'); // DEBUG log
        $this->reset([
            'first_name',
            'last_name',
            'email',
            'email_confirmation',
            'password',
            'password_confirmation',
            'agree_terms',
            'create_account',
        ]);

        $this->resetErrorBag();
        $this->resetValidation();
    }



    public function render()
    {
        return view('livewire.auth.register-page');
    }
}

