<?php

namespace App\Livewire;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Room Details Page')]

class RoomDetailsPage extends Component
{
    public function render()
    {
        return view('livewire.room-details-page');
    }
}
