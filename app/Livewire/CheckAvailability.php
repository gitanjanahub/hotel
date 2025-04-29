<?php

namespace App\Livewire;

use App\Models\Room;
use Illuminate\Support\Collection;
use Livewire\Component;
//use Livewire\Attributes\On;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;


class CheckAvailability extends Component
{

    //use LivewireAlert;

    public $check_in = null;
    public $check_out = null;
    public $selectedRoomId = null;
    public $adults = 1;
    public $children = 0;
    public $roomsCount = 1;


    /** @var Collection<int, Room> */
    public Collection $roomList;

    public function showAlert()
    {
        LivewireAlert::text('gfg')
        ->error()
        ->position('bottom-end')
        ->timer(3000)
        ->toast()
        ->show();

    }
    public function mount()
    {

        $this->check_in = Carbon::today()->format('Y-m-d');
        $this->check_out = Carbon::tomorrow()->format('Y-m-d');

        // $this->roomList = Room::select('id', 'name')
        //     ->where('available_rooms', '>', 0)
        //     ->active()
        //     ->get();

        // $this->roomList = Room::selectRaw('MIN(id) as id, name')
        //     ->where('available_rooms', '>', 0)
        //     ->active()
        //     ->groupBy('name')
        //     ->orderBy('name') // optional: alphabetically sorted
        //     ->get();


        // if ($this->roomList->isNotEmpty()) {
        //     $this->selectedRoomId = $this->roomList->first()->id;
        //     $this->updatedSelectedRoomId(); // manually initialize counts
        // }
    }



    // public function updatedSelectedRoomId()
    // {
    //     //dd(1);
    //     $room = $this->getSelectedRoom();

    //     if ($room) {
    //         $this->adults = min(1, $room->adults); // always set at least 1, but within room limit
    //         $this->children = 0;
    //     }


    // }

    public function incrementAdults()
    {
        $this->adults++;

        // if (!$this->selectedRoomId) return;

        // $room = $this->getSelectedRoom();

        // if ($this->adults < $room->adults) {
        //     $this->adults++;
        // } else {

        //     LivewireAlert::text("Maximum {$room->adults} adults allowed for this room.")
        //                 ->warning()
        //                 ->position('bottom-end')
        //                 ->timer(3000)
        //                 ->toast()
        //                 ->show();
        // }
    }




public function decrementAdults()
{
    if ($this->adults > 1) {
        $this->adults--;
    }
}

public function incrementChildren()
{
    $this->children++;
    // if (!$this->selectedRoomId) return;

    // $room = $this->getSelectedRoom();

    // if ($this->children < $room->children) {
    //     $this->children++;
    // } else {
    //     LivewireAlert::text("Maximum {$room->children} children allowed for this room.")
    //                     ->warning()
    //                     ->position('bottom-end')
    //                     ->timer(3000)
    //                     ->toast()
    //                     ->show();
    // }
}

public function decrementChildren()
{
    if ($this->children > 0) {
        $this->children--;
    }
}


    public function incrementRooms()
    {
        $this->roomsCount++;
    }

    public function decrementRooms()
    {
        if ($this->roomsCount > 1) {
            $this->roomsCount--;
        }
    }



    public function checkAvailability()
    {
        $this->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            //'selectedRoomId' => 'required|exists:rooms,id',
        ], [
            'check_in.required' => 'Please select a check-in date.',
            'check_out.required' => 'Please select a check-out date.',
            //'selectedRoomId.required' => 'Please choose a room.',
            'check_in.after_or_equal' => 'Check-in date must be today or later.',
            'check_out.after' => 'Check-out date must be after the check-in date.',
        ]);

        //$room = $this->getSelectedRoom();


        // Check if any rooms satisfy the criteria
        $totalGuests = $this->adults + $this->children;
        $perRoomGuests = (int) ceil($totalGuests / $this->roomsCount);

        $adultsPerRoom = ceil($this->adults / $this->roomsCount);
        $childrenPerRoom = ceil($this->children / $this->roomsCount);

        $hasAvailableRooms = Room::query()
            ->where('available_rooms', '>=', $this->roomsCount)
           // ->where('capacity', '>=', $perRoomGuests)
            ->where('adults', '>=', $adultsPerRoom)
            ->where('children', '>=', $childrenPerRoom)
            ->active()
            ->exists();

        if (! $hasAvailableRooms) {

            LivewireAlert::text("No rooms match your search criteria.")
                        ->warning()
                        ->position('bottom-end')
                        ->timer(3000)
                        ->toast()
                        ->show();

            return;
        }


        return redirect()->route('rooms', [
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            //'room_id' => $this->selectedRoomId,
            //'slug' => $this->getSelectedRoom()->slug,
            //'name' => $room->name,
            'adults' => $this->adults,
            'children' => $this->children,
            'room_count' => $this->roomsCount,
        ]);
    }

    // protected function getSelectedRoom()
    // {
    //     return Room::find($this->selectedRoomId);
    // }

    public function render()
    {
        return view('livewire.check-availability');
    }
}
