<?php

namespace App\Livewire;

use App\Livewire\Modals\LoginSignup;
use WireElements\Modal\Modal;

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
            ->select('id', 'name', 'slug', 'price_per_night', 'size', 'capacity', 'bed', 'images','available_rooms', 'description')
            ->with([
                'roomType',
                'roomServices' => function ($query) {
                    $query->whereNull('room_services.deleted_at');
                }
            ])
            ->where('slug', $this->slug)
            ->active()
            ->firstOrFail();

        // Decode images if it's a string
    if (is_string($this->room->images)) {
        $this->room->images = json_decode($this->room->images, true) ?? [];
    }

    // Ensure images is always an array
    if (!is_array($this->room->images)) {
        $this->room->images = [];
    }
    }

    // public function storeRoomInSessionAndEmitRedirect()
    // {
    //     // Store the room details in session
    //     //session(['selected_room' => $this->room]);

    //     session(['selected_room_id' => $this->room->id]);


    //     // Dispatch event for redirect
    //     $this->dispatch('redirectToCheckout');
    // }

    public function goToCheckout()
    {

        if (!auth()->check()) {
            $this->dispatch('openModal', component: 'modals.login-signup');
            $this->loadRoom();

            return;
        }


        session(['selected_room' => $this->room]);
        return redirect()->to('/checkout');
    }




    public function render()
    {
        return view('livewire.room-details-page', [
            'room' => $this->room,
        ]);
    }
}
