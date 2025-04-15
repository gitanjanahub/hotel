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

    public $name, $title,  $description;
    //public $short_description;
    public $home_content, $home_title, $video_url,$video_title, $video_description, $video_thumb;
    public $images = [];
    public $home_images = [];

    public function mount()
    {
        $aboutUs = ModelsAboutus::first();
        if ($aboutUs) {
            $this->name = $aboutUs->name;
            $this->title = $aboutUs->title;
            //$this->short_description = $aboutUs->short_description;
            $this->description = $aboutUs->description;
            $this->home_content = $aboutUs->home_content;
            $this->home_title = $aboutUs->home_title;
            $this->video_url = $aboutUs->video_url;  // Load video URL
            $this->video_title = $aboutUs->video_title;
            $this->video_description = $aboutUs->video_description;
            $this->video_thumb = $aboutUs->video_thumb;
        }
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'title' => 'required|string',
        //'short_description' => 'required|string',
        'description' => 'required|string',
        'home_title' => 'required|string|max:255',
        'home_content' => 'required|string',
        'video_url' => [
            'nullable',
            'url',
            'regex:/^(https?:\/\/)?(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/)[a-zA-Z0-9_-]+$/'
        ],
        'video_title' => 'nullable|string|max:255',
        'video_description' => 'nullable|string',
        'video_thumb' => 'nullable|image|max:2048',
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

        if (!empty($this->video_thumb)) {
            $thumbPath = $this->video_thumb->store('video_thumbnails', 'public');
        } else {
            $thumbPath = $aboutUs ? $aboutUs->video_thumb : null;
        }

        $formattedDescription = nl2br(e($this->description));

        if ($aboutUs) {
            $aboutUs->update([
                'name' => $this->name,
                'title' => $this->title,
                //'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'home_content' => $this->home_content,
                'video_url' => $this->video_url,  // Validate URL
                'video_title' => $this->video_title,
                'video_description' => $this->video_description,
                'video_thumb' => $thumbPath,
                'home_title' => $this->home_title,
                'images' => !empty($uploadedImages) ? json_encode($uploadedImages) : $aboutUs->images,
                'home_images' => !empty($uploadedHomeImages) ? json_encode($uploadedHomeImages) : $aboutUs->home_images,
            ]);
        } else {
            ModelsAboutus::create([
                'name' => $this->name,
                'title' => $this->title,
                //'short_description' => $this->short_description,
                'description' => $formattedDescription,
                'home_content' => $this->home_content,
                'video_url' => $this->video_url,  // Save video URL
                'video_title' => $this->video_title,
                'video_description' => $this->video_description,
                'video_thumb' => $thumbPath,
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
