<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Types')]

class RoomTypes extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $roomTypeIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedRoomTypes = []; // Array to hold selected roomtype IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function toggleActive($roomTypeId, $isActive)
    {
        $roomtype = RoomType::find($roomTypeId);

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
        $this->roomTypeIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }


    public function deleteRoomType()
    {
        if ($this->roomTypeIdToDelete) {
            $roomtype = RoomType::withCount('rooms')->find($this->roomTypeIdToDelete);

            if ($roomtype) {
                if ($roomtype->rooms_count > 0) {
                    session()->flash('error', 'roomtype cannot be deleted as it has associated products!');
                } else {
                    $roomtype->delete(); // Soft delete the roomtype
                    session()->flash('message', 'roomtype deleted successfully!');
                }

                $this->resetPage();  // Reset pagination after deletion
            } else {
                session()->flash('error', 'roomtype not found!');
            }

            $this->roomTypeIdToDelete = null;  // Reset roomtype ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // When "Select All" is checked, select all roomtype IDs
            $this->selectedRoomTypes = RoomType::pluck('id')->toArray();
        } else {
            // If "Select All" is unchecked, clear the selection
            $this->selectedRoomTypes = [];
        }
    }

    public function updatedSelectedRoomTypes($value)
    {
        // When individual checkboxes are clicked, this method ensures
        // "Select All" is checked only if all items are selected
        $this->selectAll = count($this->selectedRoomTypes) === RoomType::count();

    }

    public function confirmMultipleDelete()
    {

        // Show the multiple delete modal if any roomtypes are selected
        if (count($this->selectedRoomTypes)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteSelectedRoomTypes()
    {
        $roomtypes = RoomType::withCount('rooms')->whereIn('id', $this->selectedRoomTypes)->get();

        // Check if any roomtype has associated products
        $roomTypesWithRooms = $roomtypes->filter(function ($roomtype) {
            return $roomtype->room_count > 0;
        });

        if ($roomTypesWithRooms->count() > 0) {
            session()->flash('error', 'Some Room Types cannot be deleted because they have associated rooms!');
        } else {
            // Proceed to delete the selected roomtypes
            RoomType::whereIn('id', $this->selectedroomtypes)->delete();
            session()->flash('message', 'Selected Room Types deleted successfully!');
        }

        // Reset selected roomtypes and close modal
        $this->selectedRoomTypes = [];
        $this->showMultipleDeleteModal = false;
    }


    public function render()
    {

        // Build the query to fetch roomtypes with the count of associated rooms
        $query = RoomType::withCount('rooms');

        // Apply search filter if $this->search is not empty
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Order the query by the created_at column in descending order
        $query->orderBy('created_at', 'desc');

        // Paginate the results (5 items per page)
        $roomtypes = $query->paginate(5);


        return view('livewire.admin.room-types', [
            'roomtypes' => $roomtypes,
            'totalRoomTypesCount' => $roomtypes->total(), // Total count for display
        ]);
    }
}
