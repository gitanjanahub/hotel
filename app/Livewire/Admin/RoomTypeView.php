<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Type View')]

class RoomTypeView extends Component
{

    public $roomtype;

    public $roomtypeIdToDelete = null;

    // Mount method to load the roomtype by ID
    public function mount($roomtypeId)
    {
        //dd($roomtypeId);
        $this->roomtype = RoomType::findOrFail($roomtypeId);
    }

    public function confirmDelete($id)
    {
        $this->roomtypeIdToDelete = $id;
    }

    public function deleteRoomType()
    {
        if ($this->roomtypeIdToDelete) {
            $roomtype = RoomType::find($this->roomtypeIdToDelete);

            if ($roomtype) {
                $roomtype->delete(); // Use soft delete

                session()->flash('message', 'Room type deleted successfully!');

                return redirect()->route('admin.room-types');

                //$this->resetPage();
            } else {
                session()->flash('error', 'Room type not found!');
            }

            $this->roomtypeIdToDelete = null;
        }
    }


    public function render()
    {
        return view('livewire.admin.room-type-view');
    }
}
