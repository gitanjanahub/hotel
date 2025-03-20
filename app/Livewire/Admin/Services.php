<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('components.layouts.adminpanel')]
#[Title('Services')]

class Services extends Component
{

    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $serviceIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedServices = []; // Array to hold selected service IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function toggleActive($serviceId, $isActive)
    {
        $service = Service::find($serviceId);

        if ($service) {
            // Set is_active based on checkbox state
            $service->is_active = $isActive ? 1 : 0;
            $service->save();
            session()->flash('message', 'Status Changed successfully!');
        }
    }

    public function homeToggleActive($serviceId, $homePage)
    {
        $service = Service::find($serviceId);

        if ($service) {
            // Set is_active based on checkbox state
            $service->home_page = $homePage ? 1 : 0;
            $service->save();
            session()->flash('message', 'Status Changed successfully!');
        }
    }

    public function confirmDelete($id)
    {
        //$this->serviceIdToDelete = $id;

        // Set service ID for individual deletion and show modal
        $this->serviceIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }


    public function deleteService()
    {
        if ($this->serviceIdToDelete) {
            $service = Service::withCount('rooms')->find($this->serviceIdToDelete);

            if ($service) {
                if ($service->rooms_count > 0) {
                    session()->flash('error', 'service cannot be deleted as it has associated products!');
                } else {
                    $service->delete(); // Soft delete the service
                    session()->flash('message', 'service deleted successfully!');
                }

                $this->resetPage();  // Reset pagination after deletion
            } else {
                session()->flash('error', 'service not found!');
            }

            $this->serviceIdToDelete = null;  // Reset service ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // When "Select All" is checked, select all service IDs
            $this->selectedServices = Service::pluck('id')->toArray();
        } else {
            // If "Select All" is unchecked, clear the selection
            $this->selectedServices = [];
        }
    }

    public function updatedSelectedServices($value)
    {
        // When individual checkboxes are clicked, this method ensures
        // "Select All" is checked only if all items are selected
        $this->selectAll = count($this->selectedServices) === Service::count();

    }

    public function confirmMultipleDelete()
    {

        // Show the multiple delete modal if any services are selected
        if (count($this->selectedServices)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteSelectedServices()
    {
        $services = Service::withCount('rooms')->whereIn('id', $this->selectedServices)->get();

        // Check if any service has associated products
        $servicesWithRooms = $services->filter(function ($service) {
            return $service->room_count > 0;
        });

        if ($servicesWithRooms->count() > 0) {
            session()->flash('error', 'Some services cannot be deleted because they have associated products!');
        } else {
            // Proceed to delete the selected services
            Service::whereIn('id', $this->selectedServices)->delete();
            session()->flash('message', 'Selected services deleted successfully!');
        }

        // Reset selected services and close modal
        $this->selectedServices = [];
        $this->showMultipleDeleteModal = false;
    }


    public function render()
    {
        // Build the query to fetch services
        // $query = Service::withCount(['rooms' => function ($query) {
        //     // Ensure rooms are counted correctly considering soft deletes
        //     $query->whereNull('rooms.deleted_at');
        // }]);


        // Build the query to fetch services with the count of associated rooms
        $query = Service::withCount('rooms');

        // Apply search filter if $this->search is not empty
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Order the query by the created_at column in descending order
        $query->orderBy('created_at', 'desc');

        // Paginate the results (5 items per page)
        $services = $query->paginate(5);

        // Pass data to the Livewire component's view
        return view('livewire.admin.services', [
            'services' => $services,
            'totalServicesCount' => $services->total(), // Total count for display
        ]);
    }




}
