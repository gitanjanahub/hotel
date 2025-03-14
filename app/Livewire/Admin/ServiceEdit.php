<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Service Edit')]

class ServiceEdit extends Component
{
    public $service;
    public $name;
    public $is_active = 0;

    public function mount($id){
        $this->service = Service::findOrFail($id);
        $this->name = $this->service->name;
        $this->is_active = $this->service->is_active;
    }

    public function save()
    {
        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'is_active' => 'required|boolean',
        ]);



        // Update the brand in the database
        $updated =  $this->service->update([
                    'name' => $this->name,
                    'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
                ]);

        // Check if the update was successful
        if ($updated) {
            // Successfully updated, reset the form fields
            $this->reset(['name', 'is_active']);

            // Flash success message
            session()->flash('message', 'Service updated successfully!');

            // Redirect to brands list
            return redirect()->route('admin.services');
        } else {
            // If the update failed, flash an error message
            session()->flash('error', 'There was an issue updating the service. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.admin.service-edit');
    }
}
