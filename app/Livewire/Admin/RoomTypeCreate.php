<?php

namespace App\Livewire\Admin;

use App\Models\RoomType;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Room Type Create')]

class RoomTypeCreate extends Component
{

    public $name;
    public $description;
    public $is_active = 0;



    public function save(){

        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'min:3|max:255',
            'is_active' => 'required|boolean',
        ]);




        // Save the roomtype to the database
        $saved = RoomType::create([
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
        ]);

        if($saved){

            // Reset form fields after successful submission
            $this->reset(['name', 'description','is_active']);

            // Send success message and redirect
            session()->flash('message', 'Room Type created successfully!');
            return redirect()->route('admin.room-types'); // Ensure this route exists

        }else{

            // If the save failed, flash an error message
            session()->flash('error', 'There was an issue saving the room type. Please try again.');

        }

    }

    public function render()
    {
        return view('livewire.admin.room-type-create');
    }
}
