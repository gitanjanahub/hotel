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
    public $home_content, $home_title;
    public $images = [];
    public $home_images = [];

    public function mount()
    {
        $aboutUs = ModelsAboutus::first();
        if ($aboutUs) {
            $this->name = $aboutUs->name;
            $this->title = $aboutUs->title;
            $this->short_description = $aboutUs->short_description;
            $this->description = $aboutUs->description;
            $this->home_content = $aboutUs->home_content;
            $this->home_title = $aboutUs->home_title;
        }
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'title' => 'required|string',
        'short_description' => 'required|string',
        'description' => 'required|string',
        'home_title' => 'required|string|max:255',
        'home_content' => 'required|string',
        'images.*' => 'image|max:2048',
        'home_images.*' => 'image|max:2048',
    ];

    public function saveAboutUs()
    {
        $this->validate();

        $aboutUs = ModelsAboutus::first();

        $uploadedImages = [];
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                $uploadedImages[] = $image->store('about_us_images', 'public');
            }
        }

        $uploadedHomeImages = [];
        if (!empty($this->home_images)) {
            foreach ($this->home_images as $image) {
                $uploadedHomeImages[] = $image->store('about_us_home_images', 'public');
            }
        }

        $formattedDescription = nl2br(e($this->description));

        if ($aboutUs) {
            $aboutUs->update([
                'name' => $this->name,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'home_content' => $this->home_content,
                'home_title' => $this->home_title,
                'images' => !empty($uploadedImages) ? json_encode($uploadedImages) : $aboutUs->images,
                'home_images' => !empty($uploadedHomeImages) ? json_encode($uploadedHomeImages) : $aboutUs->home_images,
            ]);
        } else {
            ModelsAboutus::create([
                'name' => $this->name,
                'title' => $this->title,
                'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'home_content' => $this->home_content,
                'home_title' => $this->home_title,
                'images' => json_encode($uploadedImages),
                'home_images' => json_encode($uploadedHomeImages),
            ]);
        }

        session()->flash('message', 'About Us details saved successfully!');
    }

    public function render()
    {
        return view('livewire.admin.aboutus', [
            'aboutUs' => ModelsAboutus::first(),
        ]);
    }
}
