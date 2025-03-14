<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Service View')]

class ServiceView extends Component
{

    public $service;

    public $serviceIdToDelete = null;

    // Mount method to load the service by ID
    public function mount($serviceId)
    {
        //dd($serviceId);
        $this->service = Service::findOrFail($serviceId);
    }

    public function confirmDelete($id)
    {
        $this->serviceIdToDelete = $id;
    }

    public function deleteService()
    {
        if ($this->serviceIdToDelete) {
            $service = Service::find($this->serviceIdToDelete);

            if ($service) {
                $service->delete(); // Use soft delete

                session()->flash('message', 'Service deleted successfully!');

                return redirect()->route('admin.services');

                //$this->resetPage();
            } else {
                session()->flash('error', 'Service not found!');
            }

            $this->serviceIdToDelete = null;
        }
    }

    public function render()
    {
        return view('livewire.admin.service-view');
    }
}
