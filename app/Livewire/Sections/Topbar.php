<?php

namespace App\Livewire\Sections;

use App\Models\CompanyDetail;
use Livewire\Component;

class Topbar extends Component
{

    public $contactDetail;

    public function mount()
    {

        $this->contactDetail = CompanyDetail::select('phone', 'email','facebook', 'twitter', 'instagram','youtube')->first();
    }

    public function render()
    {
        return view('livewire.sections.topbar');
    }
}
