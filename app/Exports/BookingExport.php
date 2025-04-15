<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements FromCollection, WithHeadings, WithMapping
{
    protected $bookings;

    public function __construct(Collection $bookings)
    {
        $this->bookings = $bookings;
    }

    public function collection()
    {
        return $this->bookings;
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->customer_name,
            $booking->customer_phone,
            optional($booking->room)->name,
            $booking->no_of_rooms,
            number_format($booking->total_price, 2) . ' ' . ($booking->currency ?? 'INR'),
            ucfirst($booking->payment_status),
            ucfirst($booking->status),
            Carbon::parse($booking->check_in_datetime)->format('d M Y, g:i A'),
            Carbon::parse($booking->check_out_datetime)->format('d M Y, g:i A'),
            Carbon::parse($booking->created_at)->format('d M Y, h:i A'),
        ];
    }


    public function headings(): array
    {
        return [
            'Booking ID',
            'Customer Name',
            'Phone',
            'Room',
            'No. of Rooms',
            'Total Price',
            'Payment Status',
            'Booking Status',
            'Check-In',
            'Check-Out',
            'Booked At',
        ];
    }
}
