<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.adminpanel')]
#[Title('Service Edit')]

class ServiceEdit extends Component
{
    public $service, $description;
    public $name;
    //public $image;
    public $home_page = 0;
    public $is_active = 0;

    public function mount($id){
        $this->service = Service::findOrFail($id);
        $this->name = $this->service->name;
        $this->description = $this->service->description;
        //$this->image = $this->testimonial->image; // Store the existing image path
        $this->is_active = $this->service->is_active;
        $this->home_page = $this->service->home_page;
    }

    public function save()
    {
        // Validate the input fields, including the image
        $this->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'string',
            'home_page' => 'required|boolean',
            'is_active' => 'required|boolean',
            //'newImage' => 'nullable|image|max:2048', // New image is optional
        ]);

        // Check if a new image is uploaded
        // if ($this->newImage) {
        //     // Delete the old image if it exists
        //     if ($this->image && Storage::disk('public')->exists($this->image)) {
        //         Storage::disk('public')->delete($this->image);
        //     }

        //     // Upload new image
        //     $this->image = $this->newImage->store('images/services', 'public');
        // }



        // Update the brand in the database
        $updated =  $this->service->update([
                    'name' => $this->name,
                    'description' => $this->description,
                    //'image' => $this->image, // Update only if changed
                    'home_page' => $this->home_page ? 1 : 0, // Convert true/false to 1/0
                    'is_active' => $this->is_active ? 1 : 0, // Convert true/false to 1/0
                ]);

                // Reset form fields
        //$this->reset(['newImage']);

        // Check if the update was successful
        if ($updated) {
            // Successfully updated, reset the form fields
            $this->reset(['name', 'description' , 'home_page' , 'is_active']);

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
