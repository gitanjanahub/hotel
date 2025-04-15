<?php

namespace App\Livewire\Admin;

use App\Exports\RoomTypeExport;
use App\Imports\RoomtypeImport;
use App\Models\RoomType;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Types')]

class RoomTypes extends Component
{

    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $roomTypeIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedRoomTypes = []; // Array to hold selected roomtype IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $importFile;

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
            RoomType::whereIn('id', $this->selectedRoomTypes)->delete();
            session()->flash('message', 'Selected Room Types deleted successfully!');
        }

        // Reset selected roomtypes and close modal
        $this->selectedRoomTypes = [];
        $this->showMultipleDeleteModal = false;
    }

    public function importRoomtypes()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $import = new RoomtypeImport(); // ✅ Create an instance
            Excel::import($import, $this->importFile); // ✅ Pass instance to import

            if ($import->getRowCount() > 0) {
                session()->flash('message', 'Room types imported successfully!');
            } else {
                session()->flash('error', 'The file is empty or contains no valid data.');
            }

            $this->reset('importFile');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to import room types: ' . $e->getMessage());
        }
    }




    public function export($format)
    {
        $fileName = 'roomtypes_' . now()->format('Y-m-d_H-i-s');

        // Determine the list of Room Types to export
        $roomtypes = count($this->selectedRoomTypes)
            ? RoomType::withCount('rooms')->whereIn('id', $this->selectedRoomTypes)->get()
            : RoomType::withCount('rooms')
                ->when($this->search, fn ($query) => $query->where('name', 'like', '%' . $this->search . '%'))
                ->get();

                if ($format === 'pdf') {
                    // ✅ Map the Room Types into the expected format
                    $mappedRoomTypes = $roomtypes->map(function ($roomtype) {
                        return [
                            'Room Type Name' => $roomtype->name,
                            'Rooms' => $roomtype->rooms_count,
                            'Is Active' => $roomtype->is_active ? 'Yes' : 'No',
                            'Created At' => $roomtype->created_at->format('d M Y, h:i A'),
                        ];
                    });

                    $pdf = Pdf::loadView('exports.roomtypes_pdf', ['roomtypes' => $mappedRoomTypes]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->stream();
                    }, $fileName . '.pdf');
                }

        // For Excel/CSV export
        return Excel::download(new RoomTypeExport($roomtypes), $fileName . '.' . $format);
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
