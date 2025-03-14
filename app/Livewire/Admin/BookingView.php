<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use Livewire\Component;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.adminpanel')]
#[Title('Booking View')]

class BookingView extends Component
{

    public $booking;

    public function mount($bookingId)
    {
        try {
            // Fetch the booking data with related room details
            $this->booking = Booking::with('room')->findOrFail($bookingId);
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Booking not found!');
            return redirect()->route('admin.bookings');
        }
    }

    public function render()
    {
        return view('livewire.admin.booking-view');
    }
}
