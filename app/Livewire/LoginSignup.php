<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class LoginSignup extends ModalComponent
{
    public function render()
    {
        return view('livewire.login-signup');
    }
}
