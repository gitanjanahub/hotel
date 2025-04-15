<?php

namespace App\Livewire;


use App\Models\Contactus as ModelsContactus;

use App\Models\CompanyDetail;
use Livewire\Attributes\Title;

use Livewire\Component;

#[Title('Contact Us Page')]

class ContactUsPage extends Component
{

    public $name, $email, $message;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();

        ModelsContactus::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        session()->flash('success', 'Your message has been sent successfully!');
        $this->reset(); // Clear form fields
    }


    public function render()
    {
        $company_details = CompanyDetail::select('description', 'address', 'phone', 'email', 'fax', 'latitude', 'longitude')->first();


        return view('livewire.contact-us-page',compact(
            'company_details'
        ));
    }
}
