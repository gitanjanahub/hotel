<?php
namespace App\Livewire\Admin;

use App\Models\Aboutus as ModelsAboutus;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.adminpanel')]
#[Title('About Us Details')]

class Aboutus extends Component
{
    use WithFileUploads;

    public $name, $title, $short_description, $description;
    public $images = []; // Make it an array for multiple file uploads

    public function mount()
    {
        $aboutUs = ModelsAboutus::first();
        if ($aboutUs) {
            $this->name = $aboutUs->name;
            $this->title = $aboutUs->title;
            $this->short_description = $aboutUs->short_description;
            $this->description = $aboutUs->description;
        }
    }

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'title' => 'required|string',
        'short_description' => 'required|string',
        'description' => 'required|string',
        'images.*' => 'image|max:2048', // Validate multiple images
    ];

    public function saveAboutUs()
    {
        $this->validate();

        $uploadedImages = [];

        // Loop through each uploaded image
        foreach ($this->images as $image) {
            $uploadedImages[] = $image->store('about_us_images', 'public');
        }

        $formattedDescription = nl2br(e($this->description));

        $aboutUs = ModelsAboutus::first();

        if ($aboutUs) {
            $aboutUs->update([
                'name' => $this->name,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'images' => json_encode($uploadedImages),
            ]);
        } else {
            ModelsAboutus::create([
                'name' => $this->name,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'images' => json_encode($uploadedImages),
            ]);
        }

        session()->flash('message', 'About Us details saved successfully!');
    }

    public function render()
    {
        $aboutUs = ModelsAboutus::first(); // Fetch data from the database

        return view('livewire.admin.aboutus', [
            'aboutUs' => $aboutUs,
        ]);
    }
}
