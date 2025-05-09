<?php

namespace App\Livewire;

use App\Models\Room;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

#[Title('Checkout Page')]

class CheckoutPage extends Component
{
    public $check_in = null;
    public $check_out = null;
    public $adults = 1;
    public $children = 0;
    public $roomsCount = 1;

    public $name;
    public $email;
    public $phone;

    public function mount()
    {
        if (!Auth::check()) {
            session(['url.intended' => route('checkout')]);
            return redirect()->route('login');
        }

        // Optional: pre-fill user data
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }


    public function incrementAdults()
    {
        $this->adults++;
    }


    public function decrementAdults()
    {
        if ($this->adults > 1) {
            $this->adults--;
        }
    }

    public function incrementChildren()
    {
        $this->children++;
    }

    public function decrementChildren()
    {
        if ($this->children > 0) {
            $this->children--;
        }
    }


    public function incrementRooms()
    {
        $this->roomsCount++;
    }

    public function decrementRooms()
    {
        if ($this->roomsCount > 1) {
            $this->roomsCount--;
        }
    }

    public function booknow()
    {

        $selectedRoom = session('selected_room');
        $roomId = $selectedRoom?->id; // Use null-safe operator to avoid errors
        dd($roomId);

        $this->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ], [
            'check_in.required' => 'Please select a check-in date.',
            'check_out.required' => 'Please select a check-out date.',
            'check_in.after_or_equal' => 'Check-in date must be today or later.',
            'check_out.after' => 'Check-out date must be after the check-in date.',
            'name.required' => 'Please enter name.',
            'email.required' => 'Please enter email.',
            'email.email' => 'Enter a valid email address.',
            'phone.required' => 'Please enter phone.',
        ]);

        $totalGuests = $this->adults + $this->children;
        $perRoomGuests = (int) ceil($totalGuests / $this->roomsCount);

        $adultsPerRoom = ceil($this->adults / $this->roomsCount);
        $childrenPerRoom = ceil($this->children / $this->roomsCount);

        $hasAvailableRooms = Room::query()
            ->where('available_rooms', '>=', $this->roomsCount)
            ->where('adults', '>=', $adultsPerRoom)
            ->where('children', '>=', $childrenPerRoom)
            ->active()
            ->exists();

        if (! $hasAvailableRooms) {
            LivewireAlert::text("No rooms match your search criteria.")
                ->warning()
                ->position('bottom-end')
                ->timer(3000)
                ->toast()
                ->show();

            return;
        }

        // Proceed with redirect or booking logic...
    }



    public function render()
    {
        return view('livewire.checkout-page');
    }
}
