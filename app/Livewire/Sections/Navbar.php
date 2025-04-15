<?php

namespace App\Livewire\Sections;

use App\Models\CompanyDetail;
use Livewire\Component;

class Navbar extends Component
{

    public $contactDetail;

    public function mount()
    {

        $this->contactDetail = CompanyDetail::select('phone', 'email', 'facebook', 'twitter', 'instagram','youtube','logo')->first();
    }

    public function render()
    {
        return view('livewire.sections.navbar');
    }
}
