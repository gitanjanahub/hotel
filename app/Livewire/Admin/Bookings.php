<?php

namespace App\Livewire\Admin;

use App\Exports\BookingExport;
use App\Models\Booking;
use App\Models\Room;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('components.layouts.adminpanel')]
#[Title('Bookings')]

class Bookings extends Component
{

    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'bootstrap';

    public $status = 'all'; // Default to 'all'

    public $bookingIdToDelete = null;

    public $search; // Add a public property for the search term

    public $selectedBookings = []; // Array to hold selected booking IDs

    public $selectAll = false; // Property for "Select All" checkbox

    public $showDeleteModal = false; // Control visibility of the single delete modal

    public $showMultipleDeleteModal = false; // Control visibility of the multiple delete modal

    protected $queryString = ['search', 'status']; // Maintain URL state

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->status = request()->query('status', 'all'); // Get from URL or default to 'all'
    }

    public function toggleActive($bookingId, $isActive)
    {
        $booking = Booking::find($bookingId);

        if ($booking) {
            // Set is_active based on checkbox state
            $booking->is_active = $isActive ? 1 : 0;
            $booking->save();
            session()->flash('message', 'Status Changed successfully!');
        }
    }

    public function confirmDelete($id)
    {
        //$this->bookingIdToDelete = $id;

        // Set booking ID for individual deletion and show modal
        $this->bookingIdToDelete = $id;
        $this->showDeleteModal = true;  // Show the individual delete modal
    }


    // public function deleteBooking()
    // {
    //     if ($this->bookingIdToDelete) {
    //         $booking = Booking::find($this->bookingIdToDelete);

    //         if ($booking) {
    //             session()->flash('message', 'booking deleted successfully!');

    //             $this->resetPage();  // Reset pagination after deletion
    //         } else {
    //             session()->flash('error', 'booking not found!');
    //         }

    //         $this->bookingIdToDelete = null;  // Reset booking ID after deletion
    //         $this->showDeleteModal = false;  // Hide the modal after deletion
    //     }
    // }

    public function updatedSelectAll($value)
    {

        if ($value) {
            // When "Select All" is checked, select all booking IDs
            $this->selectedBookings = Booking::pluck('id')->toArray();
        } else {
            // If "Select All" is unchecked, clear the selection
            $this->selectedBookings = [];
        }
    }

    public function updatedSelectedBookings($value)
    {
        // When individual checkboxes are clicked, this method ensures
        // "Select All" is checked only if all items are selected
        $this->selectAll = count($this->selectedBookings) === Booking::count();

    }

    public function confirmMultipleDelete()
    {

        // Show the multiple delete modal if any bookings are selected
        if (count($this->selectedBookings)) {
            $this->showMultipleDeleteModal = true;
        }
    }


    public function deleteBooking()
{
    if ($this->bookingIdToDelete) {
        $booking = Booking::find($this->bookingIdToDelete);

        if ($booking) {
            // Only restore available rooms if the booking status is Pending or Confirmed,
            // and check if it's not already checked out
            if (($booking->status == 'Pending' || $booking->status == 'Confirmed') && $booking->check_in_status !== 'Checked Out') {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->increment('available_rooms', $booking->no_of_rooms);
                }
            }

            // Proceed to delete the booking
            $booking->delete();

            session()->flash('message', 'Booking deleted successfully!');

            $this->resetPage();  // Reset pagination after deletion
        } else {
            session()->flash('error', 'Booking not found!');
        }

        $this->bookingIdToDelete = null;  // Reset booking ID after deletion
        $this->showDeleteModal = false;  // Hide the modal after deletion
    }
}

public function deleteSelectedBookings()
{
    // Fetch selected bookings
    $bookings = Booking::whereIn('id', $this->selectedBookings)->get();

    // Loop through each selected booking and handle room availability based on status
    foreach ($bookings as $booking) {
        // Only restore available rooms if the booking status is Pending or Confirmed
        // and if it's not already checked out
        if (($booking->status == 'Pending' || $booking->status == 'Confirmed') && $booking->check_in_status !== 'Checked Out') {
            $room = Room::find($booking->room_id);
            if ($room) {
                $room->increment('available_rooms', $booking->no_of_rooms);
            }
        }
    }

    // Delete the selected bookings
    Booking::whereIn('id', $this->selectedBookings)->delete();

    session()->flash('message', 'Selected bookings deleted successfully!');

    // Reset selected bookings and close modal
    $this->selectedBookings = [];
    $this->showMultipleDeleteModal = false;
}



    // public function deleteSelectedBookings()
    // {

    //     Booking::whereIn('id', $this->selectedBookings)->delete();

    //     session()->flash('message', 'Selected bookings deleted successfully!');

    //     // Reset selected bookings and close modal
    //     $this->selectedBookings = [];
    //     $this->showMultipleDeleteModal = false;
    // }

    public function updateStatus($bookingId, $newStatus)
    {
        $booking = Booking::find($bookingId);

        if ($booking) {
            // Check if the booking's current status is Pending or Confirmed and adjust available_rooms accordingly
            if (($booking->status == 'Pending' || $booking->status == 'Confirmed') && $newStatus == 'Cancelled') {
                // If status is changing to Cancelled, restore the rooms back to the available_rooms in the room table
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->increment('available_rooms', $booking->no_of_rooms);
                }
            } elseif ($booking->status == 'Cancelled' && ($newStatus == 'Pending' || $newStatus == 'Confirmed')) {
                // If status is changing to Pending or Confirmed, decrement available_rooms
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->decrement('available_rooms', $booking->no_of_rooms);
                }
            }

            // Update the booking status
            $booking->update(['status' => $newStatus]);

            session()->flash('message', 'Booking status updated successfully!');
        }
    }


    public function updateCheckIn($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        if ($booking->check_in_status !== 'Not Checked In') {
            return;
        }

        $booking->update(['check_in_status' => 'Checked In']);

        session()->flash('message', 'Booking marked as Checked In!');
    }

    public function updateCheckOut($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        // Ensure only Checked In bookings can be marked as Checked Out
        if ($booking->check_in_status !== 'Checked In') {
            return;
        }

        // Update check-in status to Checked Out
        $booking->update(['check_in_status' => 'Checked Out']);

        // Only increment available rooms if booking is NOT cancelled
        if ($booking->status !== 'Cancelled') {
            $room = Room::find($booking->room_id);
            if ($room) {
                $room->increment('available_rooms', $booking->no_of_rooms);
            }
        }

        session()->flash('message', 'Booking marked as Checked Out!');
    }





    // public function updateStatus($bookingId, $newStatus)
    // {
    //     $booking = Booking::findOrFail($bookingId);
    //     $room = $booking->room; // Assuming there's a relationship: Booking belongs to Room

    //     if (!$room) {
    //         session()->flash('error', 'Room not found!');
    //         return;
    //     }

    //     $previousStatus = $booking->status;
    //     $noOfRooms = $booking->no_of_rooms;

    //     // Handle available_rooms logic
    //     if ($previousStatus !== $newStatus) {
    //         if ($newStatus == 'Cancelled') {
    //             // If the booking is cancelled, restore the available rooms
    //             $room->increment('available_rooms', $noOfRooms);
    //         } elseif ($previousStatus == 'Pending' && $newStatus == 'Confirmed') {
    //             // If moving from Pending to Confirmed, reduce available rooms
    //             if ($room->available_rooms >= $noOfRooms) {
    //                 $room->decrement('available_rooms', $noOfRooms);
    //             } else {
    //                 session()->flash('error', 'Not enough rooms available.');
    //                 return;
    //             }
    //         } elseif ($previousStatus == 'Confirmed' && $newStatus == 'Pending') {
    //             // If moving from Confirmed back to Pending, increase available rooms
    //             $room->increment('available_rooms', $noOfRooms);
    //         }
    //     }

    //     // Update the booking status
    //     $booking->update(['status' => $newStatus]);

    //     session()->flash('message', 'Booking status updated successfully!');
    // }



    // public function render()
    // {
    //     $bookings = Booking::query()
    //         ->when($this->search, function ($query) {
    //             $query->where('customer_name', 'like', '%' . $this->search . '%')
    //                 ->orWhere('customer_email', 'like', '%' . $this->search . '%')
    //                 ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
    //                 ->orWhere('status', 'like', '%' . $this->search . '%')
    //                 ->orWhereHas('room', function ($roomQuery) { // Search by room name
    //                     $roomQuery->where('name', 'like', '%' . $this->search . '%');
    //                 });
    //         })

    //         ->when($this->status !== 'all', function ($query) {
    //             $query->where('status', $this->status);
    //         })

    //         ->with('room') // Eager load room details
    //         ->latest()
    //         ->paginate(1);

    //     return view('livewire.admin.bookings', [
    //         'bookings' => $bookings,
    //         'totalBookingsCount' => $bookings->total(),
    //     ]);
    // }

    public function export($format)
    {
        $fileName = 'bookings_' . now()->format('Y-m-d_H-i-s');

        // Fetch bookings with search and status filters
        $bookings = Booking::with('room')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('room', function ($roomQuery) {
                        $roomQuery->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->get();

        if ($format === 'pdf') {
            $mappedBookings = $bookings->map(function ($booking, $index) {
                return [
                    'S.No' => $index + 1,
                    'Customer Name' => $booking->customer_name,
                    'Phone' => $booking->customer_phone,
                    'Room' => optional($booking->room)->name,
                    'No. of Rooms' => $booking->no_of_rooms,
                    'Total Price' => number_format($booking->total_price, 2) . ' ' . ($booking->currency ?? 'INR'),
                    'Payment Status' => ucfirst($booking->payment_status),
                    'Booking Status' => ucfirst($booking->status),
                    'Check-In' => Carbon::parse($booking->check_in_datetime)->format('d M Y, g:i A'),
                    'Check-Out' => Carbon::parse($booking->check_out_datetime)->format('d M Y, g:i A'),
                    'Booked At' => Carbon::parse($booking->created_at)->format('d M Y, h:i A'),
                ];
            });


            $pdf = Pdf::loadView('exports.bookings_pdf', [
                'bookings' => $mappedBookings
            ]);

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $fileName . '.pdf');
        }

        // Excel/CSV export
        return Excel::download(new BookingExport($bookings), $fileName . '.' . $format);
    }


    public function render()
    {
        $bookings = Booking::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_email', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_phone', 'like', '%' . $this->search . '%')
                    ->orWhereHas('room', function ($roomQuery) {
                        $roomQuery->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->with('room') // Eager load room details
            ->latest()
            ->paginate(10);

        return view('livewire.admin.bookings', [
            'bookings' => $bookings,
            'totalBookingsCount' => $bookings->total(),
        ]);
    }


}
