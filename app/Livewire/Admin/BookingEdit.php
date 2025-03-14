<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]
#[Title('Booking Edit')]

class BookingEdit extends Component
{

    public $bookingId;
    public $rooms;
    public $room_id;
    public $customer_name;
    public $customer_email;
    public $customer_phone;
    public $check_in_datetime;
    public $check_out_datetime;
    public $total_price = 0;
    public $price = 0;
    public $no_of_rooms = 1;
    public $adults = 1;
    public $children = 0;
    public $status = 'Pending';
    public $check_in_status = 'Not Checked In';
    public $payment_status = 'Pending';
    public $payment_type;
    public $availability = null;

    public function mount($id)
    {
        $this->bookingId = $id;
        $this->rooms = Room::where('is_active', 1)->get();

        // Set default check-in to now
        $this->check_in_datetime = Carbon::now()->format('Y-m-d\TH:i');

        // Set default check-out to one day later
        $this->check_out_datetime = Carbon::now()->addDay()->format('Y-m-d\TH:i');

        $booking = Booking::findOrFail($id);
        $this->room_id = $booking->room_id;
        $this->customer_name = $booking->customer_name;
        $this->customer_email = $booking->customer_email;
        $this->customer_phone = $booking->customer_phone;
        $this->total_price = $booking->total_price;
        $this->price = $booking->price;
        $this->adults = $booking->adults;
        $this->children = $booking->children;
        $this->status = $booking->status;
        $this->check_in_status = $booking->check_in_status;
        $this->payment_status = $booking->payment_status;
        $this->payment_type = $booking->payment_type;
        $this->check_in_datetime = $booking->check_in_datetime;
        $this->check_out_datetime = $booking->check_out_datetime;
        $this->no_of_rooms = $booking->no_of_rooms;
    }


    public function updated($property, $value)
    {
        if (in_array($property, ['room_id', 'no_of_rooms', 'adults', 'children' ,'check_in_datetime', 'check_out_datetime'])) {
            $room = Room::find($this->room_id);

            if (!$room) {
                $this->total_price = 0; // Reset price if no room is selected
                return;
            }

            $this->checkAvailabilityAndCalculatePrice($room->available_rooms, $room->price_per_night);
            $this->checkAdultCount($room->adults);
            $this->checkChildrenCount($room->children);
            $this->checkRoomAvailabilityForDates($room->id);
        }
    }


    private function checkAvailabilityAndCalculatePrice($available_rooms,$price_per_night)
    {
        if (!$this->room_id || !$this->no_of_rooms) {
            $this->total_price = 0;
            return;
        }

        if ($available_rooms < $this->no_of_rooms) {
            $this->addError('no_of_rooms', 'Selected number of rooms is not available.');
            $this->price = $price_per_night;
            $this->total_price = 0; // Reset total price if selection is invalid
        } else {
            $this->resetErrorBag('no_of_rooms'); // Clear error if validation passes
            $this->resetErrorBag('room_id');
            $this->calculateTotalPrice($price_per_night);
        }
    }


    private function checkAdultCount($maxAdultsPerRoom)
    {
        $allowedAdults = $maxAdultsPerRoom * $this->no_of_rooms; // Multiply by selected rooms

        if ($this->adults > $allowedAdults) {
            $this->addError('adults', 'This room allows only ' . $allowedAdults . ' adults for ' . $this->no_of_rooms . ' room(s).');
        } else {
            $this->resetErrorBag('adults');
        }
    }

    private function checkChildrenCount($maxChildrenPerRoom)
    {
        $allowedChildren = $maxChildrenPerRoom * $this->no_of_rooms; // Multiply by selected rooms

        if ($this->children > $allowedChildren) {
            $this->addError('children', 'This room allows only ' . $allowedChildren . ' children for ' . $this->no_of_rooms . ' room(s).');
        } else {
            $this->resetErrorBag('children');
        }
    }


    private function checkRoomAvailabilityForDates($roomId)
    {
        if (!$this->check_in_datetime || !$this->check_out_datetime) {
            return false;
        }

        $now = Carbon::now();

        $checkIn = Carbon::parse($this->check_in_datetime);
        $checkOut = Carbon::parse($this->check_out_datetime);

        if ($checkOut <= $checkIn) {
            $this->addError('check_out_datetime', 'Check-out date must be later than check-in date.');
            return false;
        }

        $room = Room::find($roomId);
        if (!$room) {
            $this->addError('room_id', 'Selected room is invalid.');
            return false;
        }

        $bookedRoomsCount = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_datetime', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_datetime', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_datetime', '<=', $checkIn)
                            ->where('check_out_datetime', '>=', $checkOut);
                    });
            })
            ->sum('no_of_rooms');

        if (($room->available_rooms - $bookedRoomsCount) < $this->no_of_rooms) {
            $this->addError('room_id', 'Not enough rooms are available for the selected dates.');
            return false;
        }

        return true;
    }




    private function calculateTotalPrice($price_per_night)
    {
        // Ensure check-in and check-out dates are set
        if (!$this->check_in_datetime || !$this->check_out_datetime) {
            $this->total_price = 0;
            return;
        }

        // Parse dates using Carbon
        $checkIn = \Carbon\Carbon::parse($this->check_in_datetime);
        $checkOut = \Carbon\Carbon::parse($this->check_out_datetime);
        $nights = $checkOut->diffInDays($checkIn);

        // Validate nights count
        if ($nights <= 0) {
            $this->addError('check_out_datetime', 'Check-out date must be later than check-in date.');
            $this->total_price = 0;
            return;
        } else {
            $this->resetErrorBag('check_out_datetime');
        }

        // Ensure number of rooms is at least 1
        $rooms = max(1, $this->no_of_rooms);

        // Validate price per night
        $this->price = max(0, $price_per_night); // Ensure price is not negative

        // Calculate total price: price per night * number of rooms * number of nights
        $this->total_price = number_format($this->price * $rooms * $nights, 2, '.', '');
    }

    public function updateBooking()
    {
        $this->validate([
            'room_id' => 'required|exists:rooms,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15',
            'check_in_datetime' => 'required|date|after_or_equal:today',
            'check_out_datetime' => 'required|date|after:check_in_datetime',
            'total_price' => 'required|numeric|min:0',
            'no_of_rooms' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
            'check_in_status' => 'required|in:Not Checked In,Checked In,Checked Out',
            'payment_status' => 'required|in:Pending,Paid',
            'payment_type' => 'required|in:cod,online,bank_transfer',
        ]);

        $checkIn = Carbon::parse($this->check_in_datetime);
        $checkOut = Carbon::parse($this->check_out_datetime);

        // Ensure check-out is at least 24 hours after check-in
        if ($checkOut->diffInHours($checkIn) < 24) {
            $this->addError('check_out_datetime', 'Check-out must be at least 1 day after check-in.');
            return;
        }

        // Check room availability before updating (skip if status is "Cancelled")
        if ($this->status !== 'Cancelled' && !$this->checkRoomAvailabilityForDates($this->room_id)) {
            return;
        }

        // Find the existing booking
        $booking = Booking::findOrFail($this->bookingId);
        $previousRoomId = $booking->room_id;
        $previousNoOfRooms = $booking->no_of_rooms;
        $previousStatus = $booking->status;
        $previousCheckInStatus = $booking->check_in_status;

        // Update the booking details
        $booking->update([
            'room_id' => $this->room_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'check_in_datetime' => $this->check_in_datetime,
            'check_out_datetime' => $this->check_out_datetime,
            'price' => $this->price,
            'total_price' => $this->total_price,
            'status' => $this->status,
            'check_in_status' => $this->check_in_status,
            'no_of_rooms' => $this->no_of_rooms,
            'adults' => $this->adults,
            'children' => $this->children,
            'payment_status' => $this->payment_status,
            'payment_type' => $this->payment_type,
        ]);

        // Handle room availability updates
        if ($this->status === 'Cancelled') {
            // If booking is canceled, restore available rooms
            $room = Room::find($this->room_id);
            if ($room) {
                $room->increment('available_rooms', $this->no_of_rooms);
            }
        } else {
            if ($previousRoomId != $this->room_id) {
                // Restore available rooms for the previous room
                $previousRoom = Room::find($previousRoomId);
                if ($previousRoom) {
                    $previousRoom->increment('available_rooms', $previousNoOfRooms);
                }

                // Decrease available rooms for the new room
                $newRoom = Room::find($this->room_id);
                if ($newRoom) {
                    $newRoom->decrement('available_rooms', $this->no_of_rooms);
                }
            } elseif ($previousNoOfRooms != $this->no_of_rooms) {
                // If the same room is selected but the number of rooms has changed
                $room = Room::find($this->room_id);
                $difference = $this->no_of_rooms - $previousNoOfRooms;

                if ($difference > 0) {
                    // Decrease available rooms
                    $room->decrement('available_rooms', $difference);
                } elseif ($difference < 0) {
                    // Increase available rooms
                    $room->increment('available_rooms', abs($difference));
                }
            }
        }

        // Handle room availability when check-in status changes to "Checked Out"
                if ($this->check_in_status === 'Checked Out'
                && $previousCheckInStatus !== 'Checked Out'
                && $this->status !== 'Cancelled') {
                $room = Room::find($this->room_id);
                if ($room) {
                    $room->increment('available_rooms', $this->no_of_rooms);
                }
            }

        session()->flash('message', 'Booking updated successfully!');
        return redirect()->route('admin.bookings'); // Redirect to the booking list
    }




    public function render()
    {
        return view('livewire.admin.booking-edit');
    }
}
