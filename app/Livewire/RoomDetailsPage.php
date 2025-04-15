<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Room Details Page')]

class RoomDetailsPage extends Component
{

    public $slug;
    public $room;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadRoom();
    }

    public function loadRoom()
    {
        $this->room = Room::query()
            ->select('id', 'name', 'slug', 'price_per_night', 'size', 'capacity', 'bed', 'images')
            ->with([
                'roomType',
                'roomServices' => function ($query) {
                    $query->whereNull('room_services.deleted_at');
                }
            ])
            ->where('slug', $this->slug)
            ->active()
            ->firstOrFail();

        // Decode only if it's a string
        if (is_string($this->room->images)) {
            $this->room->images = json_decode($this->room->images, true) ?? [];
        }
    }


    public function render()
    {
        return view('livewire.room-details-page', [
            'room' => $this->room,
        ]);
    }
}
