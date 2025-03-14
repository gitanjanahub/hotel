<?php

namespace App\Livewire;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Room Page')]

class RoomPage extends Component
{
    public function render()
    {
        return view('livewire.room-page');
    }
}
