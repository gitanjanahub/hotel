<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Room View')]

class RoomView extends Component
{

    public $room;
    public $roomtypes;
    public $services;

    public $roomIdToDelete = null;
    public $showDeleteModal = false;

    public function mount($roomId)
    {
        $this->roomtypes = RoomType::where('is_active', 1)->get();
        $this->services = Service::where('is_active', 1)->get(); // Fetch only active services
        //$this->room = Room::with(['roomType', 'roomServices'])->findOrFail($id);
        $this->room = Room::with([
            'roomType',
            'roomServices' => function ($query) {
                $query->whereNull('room_services.deleted_at'); // Exclude soft-deleted services
            }
        ])->findOrFail($roomId);
    }

    public function confirmDelete($id)
    {
        //$this->roomtypeIdToDelete = $id;

        // Set roomtype ID for individual deletion and show modal
        $this->roomIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }


    public function deleteRoom()
    {
        if ($this->roomIdToDelete) {
            $room = Room::find($this->roomIdToDelete);

            if ($room) {
                $room->delete(); // Use soft delete

                session()->flash('message', 'Room deleted successfully!');

                return redirect()->route('admin.rooms');
            } else {
                session()->flash('error', 'Room not found!');
            }

            $this->roomIdToDelete = null;  // Reset user ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }




    public function render()
    {
        return view('livewire.admin.room-view');
    }
}
