<?php

namespace App\Livewire;

use App\Models\Room;
use Livewire\Attributes\Title;

use Livewire\Component;
use Livewire\WithPagination;

#[Title('Room Page')]

class RoomPage extends Component
{

    use WithPagination; // ✅ Enable pagination

    public $perPage = 10; // ✅ Number of rooms per page

    public function render()
    {
        $rooms = Room::query()
                    ->select('id', 'name', 'slug' ,'price_per_night', 'size', 'capacity', 'bed','image')
                    ->with([
                        'roomType',
                        'roomServices' => function ($query) {
                            $query->whereNull('room_services.deleted_at');
                        }
                    ])
                    ->active() //scope
                    ->latest()
                    ->paginate($this->perPage);

        return view('livewire.room-page', compact(
            'rooms'
        ));
    }
}
