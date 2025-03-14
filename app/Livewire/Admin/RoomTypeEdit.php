<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Type Edit')]

class RoomTypeEdit extends Component
{

    public $roomtype;
    public $name;
    public $description;
    public $is_active = 0;

    public function mount($id){
        $this->roomtype = RoomType::findOrFail($id);
        $this->name = $this->roomtype->name;
        $this->description = $this->roomtype->description;
        $this->is_active = $this->roomtype->is_active;
    }

    public function save()
    {
        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'min:3|max:255',
            'is_active' => 'required|boolean',
        ]);



        // Update the brand in the database
        $updated =  $this->roomtype->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
                ]);

        // Check if the update was successful
        if ($updated) {
            // Successfully updated, reset the form fields
            $this->reset(['name', 'description' ,'is_active']);

            // Flash success message
            session()->flash('message', 'Room Type updated successfully!');

            // Redirect to brands list
            return redirect()->route('admin.room-types');
        } else {
            // If the update failed, flash an error message
            session()->flash('error', 'There was an issue updating the room type. Please try again.');
        }
    }


    public function render()
    {
        return view('livewire.admin.room-type-edit');
    }
}
