<?php

namespace App\Livewire\Admin;

use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.adminpanel')]
#[Title('Testimonials')]

class Testimonials extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $testmonialIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedTestimonials = []; // Array to hold selected roomtype IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $listeners = ['refreshComponent' => '$refresh'];

    // public function toggleActive($testmonialId, $isActive)
    // {
    //     $testmonial = Testimonial::find($testmonialId);

    //     if ($testmonial) {
    //         // Set is_active based on checkbox state
    //         $testmonial->is_active = $isActive ? 1 : 0;
    //         $testmonial->save();
    //         session()->flash('message', 'Status Changed successfully!');
    //     }
    // }

    public function confirmDelete($id)
    {
        //$this->roomtypeIdToDelete = $id;

        // Set testmonial ID for individual deletion and show modal
        $this->testmonialIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }


    public function deleteTestimonial()
    {
        if ($this->testmonialIdToDelete) {
            $testmonial = Testimonial::find($this->testmonialIdToDelete);

            if ($testmonial) {

                    $testmonial->delete(); // Soft delete the testmonial
                    session()->flash('message', 'testmonial deleted successfully!');
                $this->resetPage();  // Reset pagination after deletion
            } else {
                session()->flash('error', 'testmonial not found!');
            }

            $this->testmonialIdToDelete = null;  // Reset testmonial ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // When "Select All" is checked, select all roomtype IDs
            $this->selectedTestimonials = Testimonial::pluck('id')->toArray();
        } else {
            // If "Select All" is unchecked, clear the selection
            $this->selectedTestimonials = [];
        }
    }

    public function updatedSelectedTestimonials($value)
    {
        // When individual checkboxes are clicked, this method ensures
        // "Select All" is checked only if all items are selected
        $this->selectAll = count($this->selectedTestimonials) === Testimonial::count();

    }

    public function confirmMultipleDelete()
    {

        // Show the multiple delete modal if any testmonial are selected
        if (count($this->selectedTestimonials)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteSelectedTestimonials()
    {
        $testmonials = Testimonial::whereIn('id', $this->selectedTestimonials)->get();

        // Check if any testmonial has associated products


        if ($testmonials) {
             // Proceed to delete the selected roomtypes
             Testimonial::whereIn('id', $this->selectedTestimonialss)->delete();
             session()->flash('message', 'Selected Room Types deleted successfully!');


        } else {
            session()->flash('error', 'Error occurs!');
        }

        // Reset selected roomtypes and close modal
        $this->selectedTestimonials = [];
        $this->showMultipleDeleteModal = false;
    }


    public function render()
    {

        // Build the query to fetch services with the count of associated rooms
        $query = Testimonial::query();

        // Apply search filter if $this->search is not empty
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Order the query by the created_at column in descending order
        $query->orderBy('created_at', 'desc');

        // Paginate the results (5 items per page)
        $testimonials = $query->paginate(5);

        //dd($testimonials);

        return view('livewire.admin.testimonials' ,[
            'testimonials' => $testimonials,
            'totalTestimonialsCount' => $testimonials->total(),
        ]);
    }
}
