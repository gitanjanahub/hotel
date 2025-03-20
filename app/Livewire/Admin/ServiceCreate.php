<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Service Create')]


class ServiceCreate extends Component
{

    public $name, $description;
    //public $image;
    public $home_page = 0;
    public $is_active = 0;



    public function save(){

        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'string',
            //'image' => 'required|image|max:2048',
            'home_page' => 'required|boolean',
            'is_active' => 'required|boolean',
        ]);




        // Save the service to the database
        $saved = Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'home_page' => $this->home_page ? 1 : 0, // Convert true/false to 1/0
            'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
        ]);

        // Only after successful validation and room creation, handle file uploads
        // if ($this->image) {
        //     $imagePath = $this->image->store('images/services', 'public');
        //     $saved->update(['image' => $imagePath]);
        // }

        if($saved){

            // Reset form fields after successful submission
            $this->reset(['name', 'description' , 'home_page' , 'is_active']);

            // Send success message and redirect
            session()->flash('message', 'Service created successfully!');
            return redirect()->route('admin.services'); // Ensure this route exists

        }else{

            // If the save failed, flash an error message
            session()->flash('error', 'There was an issue saving the service. Please try again.');

        }

    }

    public function render()
    {
        return view('livewire.admin.service-create');
    }
}
