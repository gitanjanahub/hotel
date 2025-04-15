<?php

namespace App\Livewire;
use App\Models\Aboutus as ModelsAboutus;
use App\Models\Gallery;
use App\Models\Service;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('About Us Page')]

class AboutUsPage extends Component
{
    public function render()
    {
        $aboutus = ModelsAboutus::first();

        if ($aboutus && $aboutus->images) {
            $aboutus->images = json_decode($aboutus->images, true);
        }

        $services = Service::query()
                    ->select('id', 'name', 'description')
                    ->limit(5)
                    ->active() //scope
                    ->home() //scope
                    ->get();

        $galleries = Gallery::query()
                    ->select('id', 'image')
                    ->limit(6)
                    ->get();
        return view('livewire.about-us-page',compact(
            'aboutus',
            'galleries',
            'services'
        ));
    }
}
