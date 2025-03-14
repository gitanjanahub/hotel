<?php

namespace App\Livewire\Admin;

use App\Models\Room;
use App\Models\RoomService;
use App\Models\RoomType;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Edit')]
class RoomEdit extends Component
{
    use WithFileUploads;

    public $room;
    public $roomtypes;
    public $services;
    public $name;
    public $room_type_id;
    public $price_per_night;
    public $size;
    public $capacity;
    public $adults;
    public $children;
    public $bed;
    public $selected_services = [];
    public $available_rooms;
    public $image;
    public $images = [];
    public $is_active;
    public $existingImages = [];
    public $message;

    public function mount($id)
    {
        $this->roomtypes = RoomType::where('is_active', 1)->get();
        $this->services = Service::where('is_active', 1)->get(); // Fetch only active services
        $this->room = Room::with(['roomType', 'roomServices'])->findOrFail($id);

        // Populate form fields with the room's existing data
        $this->name = $this->room->name;
        $this->room_type_id = $this->room->room_type_id;
        $this->price_per_night = $this->room->price_per_night;
        $this->size = $this->room->size;
        $this->capacity = $this->room->capacity;
        $this->adults = $this->room->adults;
        $this->children = $this->room->children;
        $this->bed = $this->room->bed;
        $this->available_rooms = $this->room->available_rooms;
        $this->is_active = $this->room->is_active;
        $this->selected_services = $this->room
                                        ->roomServices()
                                        ->whereNull('room_services.deleted_at') // Ensure only non-deleted services are retrieved
                                        ->pluck('service_id') // Adjust the column to `service_id` since `room_services` has this as its foreign key
                                        ->toArray();

        //dd($this->selected_services);

        // Load existing images
        $this->existingImages = [
            'image' => $this->room->image,
            'images' => is_string($this->room->images) ? json_decode($this->room->images, true) ?? [] : [],
        ];
    }

    public function deleteImage($imagePath, $key)
    {
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        unset($this->existingImages['images'][$key]);
        $this->existingImages['images'] = array_values($this->existingImages['images']);

        $this->room->images = json_encode($this->existingImages['images']);
        $this->room->save();

        $this->message = "Image deleted successfully.";
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|integer|exists:room_types,id',
            'price_per_night' => 'required|numeric',
            'size' => 'required|integer',
            'capacity' => 'required|integer',
            'adults' => 'required|integer',
            'children' => 'required|integer',
            'bed' => 'required|string|max:255',
            'available_rooms' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'selected_services.*' => 'integer|exists:services,id',
        ]);

        $updated = $this->room->update([
            'room_type_id' => $this->room_type_id,
            'name' => $this->name,
            'price_per_night' => $this->price_per_night,
            'size' => $this->size,
            'capacity' => $this->capacity,
            'adults' => $this->adults,
            'children' => $this->children,
            'bed' => $this->bed,
            'available_rooms' => $this->available_rooms,
            'is_active' => $this->is_active,
        ]);

        // Handle thumbnail image update
        if ($this->image) {
            if (!empty($this->existingImages['image'])) {
                Storage::disk('public')->delete($this->existingImages['image']);
            }

            $thumbPath = $this->image->store('images/rooms/thumbnails', 'public');
            $this->room->update(['image' => $thumbPath]);
        }

        // Handle other images
        $existingImages = $this->existingImages['images'] ?? [];
        $newImagePaths = [];

        if ($this->images) {
            foreach ($this->images as $image) {
                $path = $image->store('images/rooms/images', 'public');
                $newImagePaths[] = $path;
            }
        }

        $allImages = array_merge($existingImages, $newImagePaths);
        $this->room->update(['images' => json_encode($allImages)]);

        // Update room services
        $this->updateRoomServices();

        if ($updated) {
            session()->flash('message', 'Room updated successfully!');
            //return redirect()->route('admin.rooms');
            return redirect()->route('admin.rooms');
        } else {
            session()->flash('error', 'There was an issue updating the room. Please try again.');
        }
    }

    private function updateRoomServices()
    {
        $existingServices = $this->room
                                ->roomServices()
                                ->whereNull('room_services.deleted_at') // Ensure only non-deleted services are retrieved
                                ->pluck('service_id') // Adjust the column to `service_id` since `room_services` has this as its foreign key
                                ->toArray();

        $servicesToDelete = array_diff($existingServices, $this->selected_services);
        $servicesToAdd = array_diff($this->selected_services, $existingServices);

        if (!empty($servicesToDelete)) {
            RoomService::where('room_id', $this->room->id)
                ->whereIn('service_id', $servicesToDelete)
                ->delete();
        }

        foreach ($servicesToAdd as $serviceId) {
            RoomService::create([
                'room_id' => $this->room->id,
                'service_id' => $serviceId,
                'is_active' => 1,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.room-edit');
    }
}
