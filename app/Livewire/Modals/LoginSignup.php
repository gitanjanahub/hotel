<?php

//namespace App\Livewire\Auth;
namespace App\Livewire\Modals;

use LivewireUI\Modal\ModalComponent; // ✅ Correct for your installed version

class LoginSignup extends ModalComponent
{

    public $email;
    public $password;

    // protected function rules(): array
    // {
    //     return [
    //         'email' => 'required|email|max:255|exists:users,email',
    //         'password' => 'required|min:6|max:255'
    //     ];
    // }

    public function login()
    {
        dd(1);
        // $this->validate([
        //     'email' => 'required|email|max:255|exists:users,email',
        //     'password' => 'required|min:6|max:255'
        // ]);

        // You can add actual login logic here, like:
        // if (Auth::attempt([...])) { ... }

        // For now, just simulate success
        //session()->flash('success', 'Logged in successfully!');
        //$this->closeModal();
    }


    public function render()
    {
        return view('livewire.modals.login-signup');
    }
}
