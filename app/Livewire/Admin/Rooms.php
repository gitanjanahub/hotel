<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.adminpanel')]
#[Title('Rooms')]

class Rooms extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $roomIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedRooms = []; // Array to hold selected roomtype IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $listeners = ['refreshComponent' => '$refresh'];


    public function toggleActive($roomId, $isActive)
    {
        $roomtype = Room::find($roomId);

        if ($roomtype) {
            // Set is_active based on checkbox state
            $roomtype->is_active = $isActive ? 1 : 0;
            $roomtype->save();
            session()->flash('message', 'Status Changed successfully!');
        }
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

                $this->resetPage();
            } else {
                session()->flash('error', 'Room not found!');
            }

            $this->roomIdToDelete = null;  // Reset user ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // When "Select All" is checked, select all roomtype IDs
            $this->selectedRooms = Room::pluck('id')->toArray();
        } else {
            // If "Select All" is unchecked, clear the selection
            $this->selectedRooms = [];
        }
    }

    public function updatedSelectedRooms($value)
    {
        // When individual checkboxes are clicked, this method ensures
        // "Select All" is checked only if all items are selected
        $this->selectAll = count($this->selectedRooms) === Room::count();

    }

    public function confirmMultipleDelete()
    {

        // Show the multiple delete modal if any roomtypes are selected
        if (count($this->selectedRooms)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteSelectedRooms()
    {
        Room::whereIn('id', $this->selectedRooms)->delete();
        session()->flash('message', 'Selected rooms deleted successfully!');
        $this->selectedRooms = []; // Clear selected users after deletion
        $this->showMultipleDeleteModal = false;  // Hide the modal after deletion
    }



    public function render()
    {
        // $query = Room::query()
        // ->with(['roomType', 'roomServices']); // Eager load related models

        $query = Room::query()
    ->with([
        'roomType',
        'roomServices' => function ($query) {
            $query->whereNull('room_services.deleted_at'); // Specify the table name explicitly
        }
    ]);

        // Only apply search if $this->search is not empty
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        $query->orderBy('created_at', 'desc');

       // dd($query->toSql(), $query->getBindings()); // Will show the SQL query and bindings

        $rooms = $query->paginate(5);

        return view('livewire.admin.rooms',[
            'rooms' => $rooms,
            'totalRoomsCount' => $rooms->total(),
        ]);
    }
}
