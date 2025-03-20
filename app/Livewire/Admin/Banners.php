<?php

namespace App\Livewire\Admin;

use App\Models\Banner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.adminpanel')]
#[Title('About Us Details')]

class Banners extends Component
{

    use WithFileUploads;

    public $title, $description;
    public $images = []; // Make it an array for multiple file uploads

    public function mount()
    {
        $banner = Banner::first();
        if ($banner) {
            $this->title = $banner->title;
            $this->description = $banner->description;
        }
    }

    // Validation rules
    protected $rules = [
        'title' => 'required|string',
        'description' => 'required|string',
        'images.*' => 'image|max:2048', // Validate multiple images
    ];


    public function save()
    {
        $this->validate();

        $banner = Banner::first();

        // Get existing images from database
        $existingImages = $banner ? json_decode($banner->images, true) ?? [] : [];

        $uploadedImages = [];

        // Loop through each new uploaded image
        foreach ($this->images as $image) {
            $uploadedImages[] = $image->store('banner_images', 'public');
        }

        // Merge old images with new images
        $allImages = array_merge($existingImages, $uploadedImages);

        if ($banner) {
            $banner->update([
                'title' => $this->title,
                'description' => $this->description,
                'images' => json_encode($allImages),
            ]);
        } else {
            Banner::create([
                'title' => $this->title,
                'description' => $this->description,
                'images' => json_encode($allImages),
            ]);
        }

        session()->flash('message', 'Banner details saved successfully!');
    }





    public function deleteImage($imageName)
    {
        $banner = Banner::first();

        if (!$banner) {
            return;
        }

        $images = json_decode($banner->images, true); // Decode JSON to an array

        if (($key = array_search($imageName, $images)) !== false) {
            unset($images[$key]); // Remove the selected image

            // Delete the image from storage
            Storage::disk('public')->delete($imageName);

            // Update the database with new images array
            $banner->update([
                'images' => json_encode(array_values($images)), // Re-index array and encode to JSON
            ]);

            session()->flash('message', 'Image deleted successfully!');
        }
    }



    public function render()
    {
        $banner = Banner::first(); // Fetch data from the database
        return view('livewire.admin.banners', [
            'banner' => $banner,
        ]);
    }
}
