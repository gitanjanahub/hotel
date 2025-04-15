<?php

namespace App\Livewire\Admin;

use App\Models\Newsletter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NewsletterExport;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf; // For PDF (if using DomPDF)

#[Layout('components.layouts.adminpanel')]
#[Title('NewsletterSubscription')]

class NewsletterSubscription extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';



    public $newsIdToDelete = null;

    public $search = '';
    public $selectedSubscribers = [];
    public $selectAll = false;

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {

        $this->newsIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }

    public function deleteSubscriber()
    {
        if ($this->newsIdToDelete) {
            $subs = Newsletter::find($this->newsIdToDelete);

            if ($subs) {
                $subs->delete(); // Use soft delete

                session()->flash('message', 'Subscriber deleted successfully!');

                $this->resetPage();
            } else {
                session()->flash('error', 'Subscriber not found!');
            }

            $this->newsIdToDelete = null;  // Reset user ID after deletion
            $this->showDeleteModal = false;  // Hide the modal after deletion
        }
    }

    public function updatedSelectAll($value)
    {

        if ($value) {
            $this->selectedSubscribers = Newsletter::pluck('id')->toArray();
        } else {
            $this->selectedSubscribers = [];
        }
    }

    public function updatedSelectedSubscribers($value)
    {

        $this->selectAll = count($this->selectedSubscribers) === Newsletter::count();

    }

    public function confirmMultipleDelete()
    {


        if (count($this->selectedSubscribers)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteSelectedSubscribers()
    {
        Newsletter::whereIn('id', $this->selectedSubscribers)->delete();
        session()->flash('message', 'Selected subscribers deleted successfully!');
        $this->selectedSubscribers = []; // Clear selected users after deletion
        $this->showMultipleDeleteModal = false;  // Hide the modal after deletion
    }

    // public function export($format)
    // {
    //     $fileName = 'newsletter_subscribers.' . $format;

    //     if ($format === 'pdf') {
    //         $data = Newsletter::select( 'email', 'created_at')->get();
    //         $pdf = Pdf::loadView('exports.newsletters_pdf', ['data' => $data]);
    //         return response()->streamDownload(fn () => print($pdf->output()), $fileName);
    //     }

    //     return Excel::download(new NewsletterExport, $fileName);
    // }

    public function export($format)
    {
        $fileName = 'newsletter_subscribers.' . $format;

        $query = Newsletter::query();

        // Only export selected if any are selected
        if (!empty($this->selectedSubscribers)) {
            $query->whereIn('id', $this->selectedSubscribers);
        }

        $data = $query->select('email', 'created_at')->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.newsletters_pdf', ['data' => $data]);
            return response()->streamDownload(fn () => print($pdf->output()), $fileName);
        }

        // Pass data to export class
        return Excel::download(new NewsletterExport($data), $fileName);
    }


    public function render()
    {
        $newsletters = Newsletter::where('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.newsletter-subscription', [
            'newsletters' => $newsletters,
            'totalSubscribers' => Newsletter::count(),
        ]);
    }
}
