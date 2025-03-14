<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.adminpanel')]
#[Title('Booking Create')]
class BookingCreate extends Component
{
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


    public function mount()
    {
        $this->rooms = Room::where('is_active', 1)->get();

        // Set default check-in to now
        $this->check_in_datetime = Carbon::now()->format('Y-m-d\TH:i');

        // Set default check-out to one day later
        $this->check_out_datetime = Carbon::now()->addDay()->format('Y-m-d\TH:i');

    }



    // public function updated($property, $value)
    // {
    //     if ($property === 'room_id' || $property === 'no_of_rooms' || 'adults') {
    //         $room = Room::find($this->room_id);

    //         if (!$room) {
    //             //$this->availability = null; // No room selected
    //             $this->total_price = 0; // Reset price if no room is selected
    //             return;
    //         }

    //         //$this->availability = $room->available_rooms; // Update available rooms count

    //         $this->checkAvailabilityAndCalculatePrice($room->available_rooms,$room->price_per_night);
    //         $this->checkAdultCount($room->adults);
    //     }
    // }


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




    // private function checkAdultCount($adults){
    //     if($this->adults > $adults){
    //         $this->addError('adults', 'This room allow only '.$adults.' adults.');
    //     }else{
    //         $this->resetErrorBag('adults');
    //     }
    // }

    // private function checkChildrenCount($children){
    //     if($this->children > $children){
    //         $this->addError('children', 'This room allow only '.$children.' children.');
    //     }else{
    //         $this->resetErrorBag('children');
    //     }
    // }

     // Check if enough rooms are available in the selected date range
    //  private function checkRoomAvailabilityForDates($roomId)
    // {
    //     if (!$this->check_in_datetime || !$this->check_out_datetime) {
    //         return;
    //     }

    //     $checkIn = Carbon::parse($this->check_in_datetime);
    //     $checkOut = Carbon::parse($this->check_out_datetime);

    //     if ($checkOut <= $checkIn) {
    //         $this->addError('check_out_datetime', 'Check-out date must be later than check-in date.');
    //         return;
    //     } elseif ($checkOut->diffInHours($checkIn) < 24) {
    //         $this->addError('check_out_datetime', 'Check-out must be at least 1 day after check-in.');
    //         return;
    //     } else {
    //         $this->resetErrorBag('check_out_datetime');
    //     }

    //     $room = Room::find($roomId);
    //     if (!$room) {
    //         $this->addError('room_id', 'Selected room is invalid.');
    //         return;
    //     }

    //     // Count how many rooms are already booked in the given date range
    //     $bookedRoomsCount = Booking::where('room_id', $roomId)
    //         ->where(function ($query) use ($checkIn, $checkOut) {
    //             $query->whereBetween('check_in_datetime', [$checkIn, $checkOut])
    //                 ->orWhereBetween('check_out_datetime', [$checkIn, $checkOut])
    //                 ->orWhere(function ($q) use ($checkIn, $checkOut) {
    //                     $q->where('check_in_datetime', '<=', $checkIn)
    //                         ->where('check_out_datetime', '>=', $checkOut);
    //                 });
    //         })
    //         ->sum('no_of_rooms'); // Sum the number of rooms booked

    //     // Available rooms should be greater than or equal to requested rooms
    //     if (($room->available_rooms - $bookedRoomsCount) < $this->no_of_rooms) {
    //         $this->addError('room_id', 'Not enough rooms are available for the selected dates.');
    //     } else {
    //         $this->resetErrorBag('room_id');
    //     }
    // }

    private function checkRoomAvailabilityForDates($roomId)
    {
        if (!$this->check_in_datetime || !$this->check_out_datetime) {
            return;
        }

        $now = Carbon::now(); // Get the current date-time
    //echo $now;
        $checkIn = Carbon::parse($this->check_in_datetime);
        $checkOut = Carbon::parse($this->check_out_datetime);

        // 🔹 Check if check-in is in the past
        if ($checkIn < $now) {
            $this->addError('check_in_datetime', 'Check-in date must be in the future.');
            //dd($now);
            return;
        } else {
            $this->resetErrorBag('check_in_datetime');
        }

        // 🔹 Ensure check-out is later than check-in
        if ($checkOut <= $checkIn) {
            $this->addError('check_out_datetime', 'Check-out date must be later than check-in date.');
            return;
        }

        // 🔹 Ensure check-out is at least 1 day after check-in
        if ($checkOut->diffInHours($checkIn) < 24) {
            $this->addError('check_out_datetime', 'Check-out must be at least 1 day after check-in.');
            return;
        } else {
            $this->resetErrorBag('check_out_datetime');
        }

        // 🔹 Validate room availability
        $room = Room::find($roomId);
        if (!$room) {
            $this->addError('room_id', 'Selected room is invalid.');
            return;
        }

        // Count how many rooms are already booked in the given date range
        $bookedRoomsCount = Booking::where('room_id', $roomId)
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in_datetime', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_datetime', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_datetime', '<=', $checkIn)
                            ->where('check_out_datetime', '>=', $checkOut);
                    });
            })
            ->sum('no_of_rooms'); // Sum the number of rooms booked

        // Check if enough rooms are available
        if (($room->available_rooms - $bookedRoomsCount) < $this->no_of_rooms) {
            $this->addError('room_id', 'Not enough rooms are available for the selected dates.');
        } else {
            $this->resetErrorBag('room_id');
        }
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



    // Check if the room is available in the selected date range
    // private function checkRoomAvailabilityForDates($roomId)
    // {
    //     if (!$this->check_in_datetime || !$this->check_out_datetime) {
    //         return;
    //     }

    //     if ($this->check_out_datetime <= $this->check_in_datetime) {
    //         $this->addError('check_out_datetime', 'Check-out date must be later than check-in date.');
    //         return;
    //     } else {
    //         $this->resetErrorBag('check_out_datetime');
    //     }

    //     $overlappingBookings = Booking::where('room_id', $roomId)
    //         ->where(function ($query) {
    //             $query->whereBetween('check_in_datetime', [$this->check_in_datetime, $this->check_out_datetime])
    //                 ->orWhereBetween('check_out_datetime', [$this->check_in_datetime, $this->check_out_datetime])
    //                 ->orWhere(function ($q) {
    //                     $q->where('check_in_datetime', '<=', $this->check_in_datetime)
    //                         ->where('check_out_datetime', '>=', $this->check_out_datetime);
    //                 });
    //         })
    //         ->exists();

    //     if ($overlappingBookings) {
    //         $this->addError('room_id', 'This room is not available for the selected dates.');
    //     } else {
    //         $this->resetErrorBag('room_id');
    //     }
    // }

    // Calculate total price
    // private function calculateTotalPrice($price_per_night)
    // {
    //     $this->price = $price_per_night;
    //     $this->total_price = number_format($price_per_night * $this->no_of_rooms, 2, '.', '');
    // }


    public function save()
    {
        // Check room availability based on selected dates
        $this->checkRoomAvailabilityForDates($this->room_id);

        // Fetch selected room
        $room = Room::find($this->room_id);

        if (!$room) {
            $this->addError('room_id', 'Selected room is invalid.');
            return;
        }else{
            $this->resetValidation('room_id');
        }

        // Validate number of rooms
        $this->checkAvailabilityAndCalculatePrice($room->available_rooms, $room->price_per_night);

        // Validate adults and children count
        $this->checkAdultCount($room->adults);
        $this->checkChildrenCount($room->children);

        // If validation errors exist, stop execution
        if ($this->getErrorBag()->isNotEmpty()) {
            return;
        }

        // Ensure enough rooms are available
        if ($room->available_rooms < $this->no_of_rooms) {
            $this->addError('no_of_rooms', 'Not enough rooms available.');
            return;
        }

        // Perform final validation
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

        // Start transaction to prevent errors in case of failures
        DB::beginTransaction();

        try {
            // Create booking record
            Booking::create([
                'room_id' => $this->room_id,
                'customer_name' => $this->customer_name,
                'customer_email' => $this->customer_email,
                'customer_phone' => $this->customer_phone,
                'check_in_datetime' => $this->check_in_datetime,
                'check_out_datetime' => $this->check_out_datetime,
                'price' => $this->price,
                'total_price' => $this->total_price,
                'no_of_rooms' => $this->no_of_rooms,
                'adults' => $this->adults,
                'children' => $this->children,
                'status' => $this->status,
                'check_in_status' => $this->check_in_status,
                'payment_status' => $this->payment_status,
                'payment_type' => $this->payment_type,
            ]);

            // Reduce available rooms count
            $room->decrement('available_rooms', $this->no_of_rooms);

            DB::commit(); // Commit transaction

            session()->flash('success', 'Booking created successfully!');
            return redirect()->route('admin.bookings');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of any failure
            $this->addError('general', 'Something went wrong. Please try again.');
        }

    }




    // public function save()
    // {
    //     $this->validate([
    //         'room_id' => 'required|exists:rooms,id',
    //         'customer_name' => 'required|string|max:255',
    //         'customer_email' => 'required|email|max:255',
    //         'customer_phone' => 'required|string|max:15',
    //         'check_in_datetime' => 'required|date|after_or_equal:today',
    //         'check_out_datetime' => 'required|date|after:check_in_datetime',
    //         'total_price' => 'required|numeric|min:0',
    //         'no_of_rooms' => 'required|integer|min:1',
    //         'adults' => 'required|integer|min:1',
    //         'children' => 'nullable|integer|min:0',
    //         'status' => 'required|in:Pending,Confirmed,Cancelled',
    //         'check_in_status' => 'required|in:Not Checked In,Checked In,Checked Out',
    //         'payment_status' => 'required|in:Pending,Paid',
    //         'payment_type' => 'required|in:cod,online,bank_transfer',
    //     ]);

    //     Booking::create([
    //         'room_id' => $this->room_id,
    //         'customer_name' => $this->customer_name,
    //         'customer_email' => $this->customer_email,
    //         'customer_phone' => $this->customer_phone,
    //         'check_in_datetime' => $this->check_in_datetime,
    //         'check_out_datetime' => $this->check_out_datetime,
    //         'total_price' => $this->total_price,
    //         'no_of_rooms' => $this->no_of_rooms,
    //         'adults' => $this->adults,
    //         'children' => $this->children,
    //         'status' => $this->status,
    //         'check_in_status' => $this->check_in_status,
    //         'payment_status' => $this->payment_status,
    //         'payment_type' => $this->payment_type,
    //     ]);

    //     session()->flash('success', 'Booking created successfully!');
    //     return redirect()->route('admin.bookings');
    // }

    public function render()
    {
        return view('livewire.admin.booking-create');
    }
}
