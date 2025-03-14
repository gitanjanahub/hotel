<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.adminpanel')]

#[Title('Dashboard')]

class Dashboard extends Component
{
    public function render()
    {

        // Count rooms excluding soft-deleted records
        $roomsCount = Room::withoutTrashed()->count();

        // Count rooms excluding soft-deleted records
        $roomtypesCount = RoomType::withoutTrashed()->count();

        // Count bookings names excluding soft-deleted records
        //$bookingsCount = Booking::withoutTrashed()->count();

        $todayBookingsCount = Booking::withoutTrashed()
        ->where('status', '!=', 'Cancelled')
        ->whereDate('created_at', today()) // Only today's new bookings
        ->count();

        $newBookingsCount = Booking::withoutTrashed()
        ->where('status', '!=', 'Cancelled')
        ->latest('created_at') // Get the latest bookings
        ->count();



        // Count services excluding soft-deleted records
        $servicesCount = Service::withoutTrashed()->count();

        return view('livewire.admin.dashboard',[
            'roomsCount' => $roomsCount,
            'roomtypesCount' => $roomtypesCount,
            'todayBookingsCount' => $todayBookingsCount,
            'newBookingsCount' => $newBookingsCount,
            //'bookingsCount' => $bookingsCount,
            'servicesCount' => $servicesCount,
        ]);
    }
}
