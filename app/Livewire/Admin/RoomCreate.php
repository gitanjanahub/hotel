<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\RoomService;
use App\Models\RoomType;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Create')]

class RoomCreate extends Component
{

    use WithFileUploads;

    public $roomtypes;
    public $services;
    public $name;
    public $room_type_id;
    public $service_id;
    public $price_per_night;
    public $size;
    public $capacity;
    public $adults;
    public $children;
    public $bed;
    public $selected_services = [];
    public $available_rooms;
    public $image;
    public $home_thumb;
    public $images = [];
    public $is_active = 0;
    public $description;

    // protected $listeners = [
    //     'updateDescription' => 'updateDescription'
    // ];

    public function mount()
    {
        $this->roomtypes = RoomType::where('is_active', 1)->get();
        $this->services = Service::where('is_active', 1)->get(); // Fetch only active services
        //$this->dispatch('setDescription', $this->description);

        $this->dispatch('setDescription', $this->description);
    }

//     public function updateDescription($value)
// {
//     $this->description = $value;
// }





    public function save()
    {
        //dd($this->selectedAttributes);
        // Step 1: Validate form inputs, including image files
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|integer',
            'price_per_night' => 'required|numeric',
            'size' => 'required|integer',
            'capacity' => 'required|integer',
            'adults' => 'required|integer',
            'children' => 'required|integer',
            'bed' => 'required|string|max:255',
            'available_rooms' => 'required|integer',
            'image' => 'required|image|max:2048', // Image validation (max 2MB)
            'home_thumb' => 'required|image|max:2048', // Image validation (max 2MB)
            'images.*' => 'nullable|image|max:2048', // Multiple image validation (max 2MB each)
            'is_active' => 'required|boolean',
            'description' => 'required|string',
        ]);

        //$offerPrice = $this->offer_price ?? 0;  // If offer_price is not set, default it to 0


        // If validation passes, proceed with inserting data into the database

        $room = Room::create([
            'room_type_id' => $this->room_type_id,
            'name' => $this->name,
            'price_per_night' => $this->price_per_night,
            'size' => $this->size,
            'capacity' => $this->capacity,
            'adults' => $this->adults,
            'children' => $this->children,
            'bed' => $this->bed,
            'available_rooms' => $this->available_rooms,
            'is_active' => $this->is_active ? 1 : 0,
            'description' => $this->description,
        ]);

        // Only after successful validation and room creation, handle file uploads
        if ($this->image) {
            $imagePath = $this->image->store('images/rooms/thumbnails', 'public');
            $room->update(['image' => $imagePath]);
        }

        if ($this->home_thumb) {
            $homeimagePath = $this->home_thumb->store('images/rooms/thumbnails', 'public');
            $room->update(['home_thumb' => $homeimagePath]);
        }

        if (is_array($this->images) && count($this->images) > 0) {
            $imagePaths = [];
            foreach ($this->images as $image) {
                $path = $image->store('images/rooms/images', 'public');
                $imagePaths[] = $path;
            }
            $room->update(['images' => json_encode($imagePaths)]);
        }



            // Save selected services
        if (!empty($this->selected_services)) {
            foreach ($this->selected_services as $serviceId) {
                RoomService::create([
                    'room_id' => $room->id,
                    'service_id' => $serviceId,
                    'is_active' => 1,
                ]);
            }
        }

        $this->reset();

        session()->flash('message', 'Room created successfully!');
        //return redirect()->route('admin.rooms');
        //return $this->redirect('/rooms', navigate:true);
        return redirect()->route('admin.rooms');

    }


    public function render()
    {
        return view('livewire.admin.room-create');
    }
}
