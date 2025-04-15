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
    public function render()
    {
        // Fetch banner, selecting specific columns
        $banner = Banner::query()
                    ->select('id', 'title', 'description', 'images')
                    ->first();

        // Decode JSON images into an array
        if ($banner && $banner->images) {
            $banner->images = json_decode($banner->images, true);
        }

        // Fetch About Us details
        $aboutus = Aboutus::query()
                    ->select('id', 'home_title', 'home_content', 'home_images')
                    ->first();

        if ($aboutus && $aboutus->home_images) {
            $aboutus->home_images = json_decode($aboutus->home_images, true);
        }

        $services = Service::query()
                    ->select('id', 'name', 'description')
                    ->active() //scope
                    ->home() //scope
                    ->get();

        $rooms = Room::query()
                    ->select('id', 'name', 'slug' ,'price_per_night', 'size', 'capacity', 'bed','home_thumb')
                    ->with([
                        'roomType',
                        'roomServices' => function ($query) {
                            $query->whereNull('room_services.deleted_at');
                        }
                    ])
                    ->active() //scope
                    ->latest()
                    ->limit(4)
                    ->get();

        $testimonials = Testimonial::query()
                    ->select('id', 'name', 'content', 'image')
                    ->get();

        $galleries = Gallery::query()
                    ->select('id', 'image')
                    ->limit(6)
                    ->get();

        return view('livewire.home-page', compact(
            'banner',
            'aboutus',
            'services',
            'rooms',
            'testimonials',
            'galleries'
        ));
    }
}
