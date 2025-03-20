<?php

namespace App\Livewire\Admin;

use App\Models\Gallery;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.adminpanel')]
#[Title('Create Gallery')]

class CreateGallery extends Component
{

    use WithFileUploads;

    public $images = []; // Handles multiple file uploads

    public function save()
    {
        // Validate images
        $this->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:2048', // Each image max size: 2MB
        ]);

        // Loop through images and save them
        foreach ($this->images as $image) {
            $imagePath = $image->store('images/gallery', 'public');

            Gallery::create(['image' => $imagePath]); // 'image' matches your DB column name
        }

        // Reset the file input
        $this->reset('images');

        // Success message
        session()->flash('message', 'Images uploaded successfully!');
        return redirect()->route('admin.galleries');
    }



    public function render()
    {
        return view('livewire.admin.create-gallery');
    }
}
