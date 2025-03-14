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

    public $name;
    public $is_active = 0;



    public function save(){

        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'is_active' => 'required|boolean',
        ]);




        // Save the service to the database
        $saved = Service::create([
            'name' => $this->name,
            'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
        ]);

        if($saved){

            // Reset form fields after successful submission
            $this->reset(['name', 'is_active']);

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
