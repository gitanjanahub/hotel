<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Sample extends ModalComponent
{
    public function render()
    {
        return view('livewire.sample');
    }
}
