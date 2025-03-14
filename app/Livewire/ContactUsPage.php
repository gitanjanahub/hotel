<?php

namespace App\Livewire;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Contact Us Page')]

class ContactUsPage extends Component
{
    public function render()
    {
        return view('livewire.contact-us-page');
    }
}
