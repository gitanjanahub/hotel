<?php

namespace App\Livewire\Admin;

use App\Models\CompanyDetail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Company Details')]

class CompanyDetails extends Component
{

    public $company_name, $description, $address, $phone, $email, $fax;
    public $facebook, $twitter, $instagram, $youtube, $latitude, $longitude;

    public function mount()
    {
        // Load existing company details if they exist
        $company = CompanyDetail::first();

        if ($company) {
            $this->company_name = $company->company_name;
            $this->description = $company->description;
            $this->address = $company->address;
            $this->phone = $company->phone;
            $this->email = $company->email;
            $this->fax = $company->fax;
            $this->facebook = $company->facebook;
            $this->twitter = $company->twitter;
            $this->instagram = $company->instagram;
            $this->youtube = $company->youtube;
            $this->latitude = $company->latitude;
            $this->longitude = $company->longitude;
        }
    }

    public function saveCompanyDetails()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'fax' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);


        // Create or update company details
        $company = CompanyDetail::first();

        if ($company) {
            // Update existing record
            $company->update([
                'company_name' => $this->company_name,
                'description' => $this->description,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'fax' => $this->fax,
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        } else {
            // Create new record
            CompanyDetail::create([
                'company_name' => $this->company_name,
                'description' => $this->description,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'fax' => $this->fax,
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'instagram' => $this->instagram,
                'youtube' => $this->youtube,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        }

        session()->flash('message', 'Company details saved successfully!');
    }


    public function render()
    {
        return view('livewire.admin.company-details');
    }
}
