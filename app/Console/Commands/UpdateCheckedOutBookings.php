<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateCheckedOutBookings extends Command
{
    protected $signature = 'update:checkout-status';
    protected $description = 'Update checked-out bookings and restore available rooms';

    public function handle()
    {
        $now = now(); // Uses Laravel's default timezone from config

        Log::info('Found bookings to update:', ['time' => $now]);

        // Find bookings where check-out time has passed but check-in status is not "Checked Out"
        $bookings = Booking::where('check_out_datetime', '<', $now)
            ->where('check_in_status', '!=', 'Checked Out')
            ->get();

        Log::info('Found bookings to update:', ['count' => $bookings->count()]);

        foreach ($bookings as $booking) {
            // Update check-in status to "Checked Out"
            $booking->update([
                'check_in_status' => 'Checked Out',
            ]);

            Log::info('Updated booking:', ['booking_id' => $booking->id]);

            // Restore available rooms if status was Pending or Confirmed
            if (in_array($booking->status, ['Pending', 'Confirmed'])) {
                $room = Room::find($booking->room_id);
                if ($room) {
                    $room->increment('available_rooms', max(0, $booking->no_of_rooms));
                    if ($booking->status === 'Pending') {
                        $booking->update([
                            'status' => 'Cancelled',
                        ]);
                        Log::info('Booking status updated to Cancelled:', ['booking_id' => $booking->id]);
                    }
                    Log::info('Updated room availability:', [
                        'room_id' => $room->id,
                        'available_rooms' => $room->available_rooms
                    ]);
                }
            }
        }

        $this->info('Checked-out bookings updated successfully!');
    }
}
