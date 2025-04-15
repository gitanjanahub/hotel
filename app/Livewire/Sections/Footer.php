<?php

namespace App\Livewire\Sections;

use App\Models\CompanyDetail;
use Livewire\Component;

class Footer extends Component
{

    public $contactDetail;
    public $email; // for the subscription form
    public $successMessage;

    public function mount()
    {

        $this->contactDetail = CompanyDetail::select('company_name','description', 'address','phone', 'email', 'facebook', 'twitter', 'instagram','youtube','footer_logo')->first();
    }



    public function render()
    {
        return view('livewire.sections.footer');
    }
}
