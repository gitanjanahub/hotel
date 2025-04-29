<?php

namespace App\Livewire;

use App\Models\Aboutus;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Room;
use App\Models\Service;
use App\Models\Testimonial;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home Page')]
class HomePage extends Component
{

    public $banner, $bannerImages = [];
    public $aboutus, $aboutusImages = [];
    public $services = [];
    public $rooms = [];
    public $testimonials = [];
    public $galleries = [];

    public function mount()
    {
        //$this->roomList = Room::select('id', 'name')->active()->get();

        // Banner
        $this->banner = Banner::select('id', 'title', 'description', 'images')->first();
        $this->bannerImages = $this->banner && $this->banner->images
            ? json_decode($this->banner->images, true)
            : [];

        // About Us
        $this->aboutus = Aboutus::select('id', 'home_title', 'home_content', 'home_images')->first();
        $this->aboutusImages = $this->aboutus && $this->aboutus->home_images
            ? json_decode($this->aboutus->home_images, true)
            : [];

        // Services
        $this->services = Service::select('id', 'name', 'description')
            ->active()->home()->get();

        // Rooms
        $this->rooms = Room::select('id', 'name', 'slug', 'price_per_night', 'size', 'capacity', 'bed', 'home_thumb')
            ->with(['roomType', 'roomServices' => fn ($q) => $q->whereNull('room_services.deleted_at')])
            ->active()->latest()->limit(4)->get();

        // Testimonials
        $this->testimonials = Testimonial::select('id', 'name', 'content', 'image')->get();

        // Galleries
        $this->galleries = Gallery::select('id', 'image')->limit(6)->get();
    }



    public function render()
    {
        return view('livewire.home-page');
    }
}
