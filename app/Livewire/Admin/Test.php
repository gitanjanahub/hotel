<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

use Illuminate\Support\Facades\Log;

//#[Layout('components.layouts.adminpanel')]
#[Title('Booking Create')]
class Test extends Component
{
    public $rooms;
    public $room_id;

    public $no_of_rooms = 1;
    public $availability = null;


    public function mount()
    {
        $this->rooms = Room::where('is_active', 1)->get();
    }



    public function updated($property, $value)
    {
        //$this->addError('room_id', 'Selected number of rooms is not available.');
        if ($property === 'room_id' || $property === 'no_of_rooms') {
            $this->checkAvailability();
            //$this->calculateTotalPrice();
        }
    }

    private function checkAvailability()
{
    if (!$this->room_id || !$this->no_of_rooms) return;

    $room = Room::find($this->room_id);

    if (!$room) {
        $this->availability = null; // Set to null if no room is found
        return;
    }

    $this->availability = $room->available_rooms; // Store available rooms

    if ($room->available_rooms < $this->no_of_rooms) {

        $this->validateOnly('no_of_rooms', [
            'no_of_rooms' => 'max:' . $room->available_rooms,
        ], [
            'no_of_rooms.max' => 'Selected number of rooms is not available.'
        ]);

        //$this->addError('room_id', 'Selected number of rooms is not available.');
        //$this->dispatch('$refresh'); // Ensure UI updates
    } else {
        $this->resetErrorBag('no_of_rooms'); // Clears error if validation passes
    }
}



    public function render()
    {
        return view('livewire.admin.test');
    }
}
