<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Room Page')]

class RoomPage extends Component
{

    use WithPagination; // ✅ Enable pagination

    public $perPage = 10; // ✅ Number of rooms per page

    #[Url]
    public $check_in;

    #[Url]
    public $check_out;

    #[Url]
    public $room_count;

    #[Url]
    public $adults;

    #[Url]
    public $children;

    public function render()
    {
        $query = Room::query()
            ->select('id', 'name', 'slug', 'price_per_night', 'size', 'capacity', 'bed', 'image','available_rooms')
            ->with([
                'roomType',
                'roomServices' => function ($query) {
                    $query->whereNull('room_services.deleted_at');
                }
            ])
            ->active()
            ->latest();

        // Apply filter for availability and capacity
        // if ($this->room_count && $this->adults && $this->children) {
        //     $totalPeople = $this->adults + $this->children;

        //     $query->where('available_rooms', '>=', $this->room_count)
        //         ->where('capacity', '>=', $totalPeople / $this->room_count);
        // }

        if ($this->room_count && $this->adults !== null && $this->children !== null) {
            $totalGuests = $this->adults + $this->children;
            $perRoomGuests = (int) ceil($totalGuests / $this->room_count);

            $adultsPerRoom = ceil($this->adults / $this->room_count);
            $childrenPerRoom = ceil($this->children / $this->room_count);


            $query->where('available_rooms', '>=', $this->room_count)
                  //->where('capacity', '>=', $perRoomGuests);
            ->where('adults', '>=', $adultsPerRoom)
            ->where('children', '>=', $childrenPerRoom);
        }


        // Optional: filter by slug if needed
        // if (!empty($this->slug)) {
        //     $query->where('slug', $this->slug);
        // }

        $rooms = $query->paginate($this->perPage);

        return view('livewire.room-page', compact('rooms'));
    }



    // public function render()
    // {
    //     $query = Room::query()
    //                 ->select('id', 'name', 'slug' ,'price_per_night', 'size', 'capacity', 'bed','image')
    //                 ->with([
    //                     'roomType',
    //                     'roomServices' => function ($query) {
    //                         $query->whereNull('room_services.deleted_at');
    //                     }
    //                 ])
    //                 ->active()
    //                 ->latest();

    //     // Apply filter if room_id is passed
    //     if ($this->slug) {
    //         $query->where('slug', $this->slug);
    //     }


    //     $rooms = $query->paginate($this->perPage);

    //     return view('livewire.room-page', compact('rooms'));
    // }


    // public function render()
    // {
    //     $rooms = Room::query()
    //                 ->select('id', 'name', 'slug' ,'price_per_night', 'size', 'capacity', 'bed','image')
    //                 ->with([
    //                     'roomType',
    //                     'roomServices' => function ($query) {
    //                         $query->whereNull('room_services.deleted_at');
    //                     }
    //                 ])
    //                 ->active() //scope
    //                 ->latest()
    //                 ->paginate($this->perPage);

    //     return view('livewire.room-page', compact(
    //         'rooms'
    //     ));
    // }
}
