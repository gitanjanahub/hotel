<?php

namespace App\Livewire\Admin;

use App\Exports\RoomExport;
use App\Imports\RoomImport;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.adminpanel')]
#[Title('Rooms')]

class Rooms extends Component
{

    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $roomIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedRooms = []; // Array to hold selected roomtype IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    public $importFile;

    public $roomImages = [];

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

    public function updatedRoomImages()
    {
        foreach ($this->roomImages as $image) {
            $filename = $image->getClientOriginalName();
            $image->storeAs('tmp-room-images', $filename);
        }
        session()->flash('message', 'Images uploaded to temporary folder!');
    }


    public function importRooms()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        Excel::import(new RoomImport, $this->importFile);

        session()->flash('message', 'Rooms imported successfully!');
        $this->reset('importFile');
    }


    public function export($format)
    {
        $fileName = 'rooms_' . now()->format('Y-m-d_H-i-s');

        // Determine the list of Rooms to export
        $rooms = count($this->selectedRooms ?? [])
            ? Room::with(['roomType', 'roomServices' => function ($query) {
                $query->whereNull('room_services.deleted_at');
            }])->whereIn('id', $this->selectedRooms)->get()
            : Room::with(['roomType', 'roomServices' => function ($query) {
                $query->whereNull('room_services.deleted_at');
            }])
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->get();

        if ($format === 'pdf') {
            // Map rooms into expected format for PDF
            $mappedRooms = $rooms->map(function ($room, $index) {
                return [
                    'S.No' => $index + 1,
                    'Room Name' => $room->name,
                    'Room Type' => optional($room->roomType)->name,
                    'Services' => $room->roomServices->pluck('name')->implode(', '),
                    'Is Active' => $room->is_active ? 'Yes' : 'No',
                    'Created At' => $room->created_at->format('d M Y, h:i A'),
                ];
            });

            $pdf = Pdf::loadView('exports.rooms_pdf', ['rooms' => $mappedRooms]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $fileName . '.pdf');
        }

        // Excel/CSV Export
        return Excel::download(new RoomExport($rooms), $fileName . '.' . $format);
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
