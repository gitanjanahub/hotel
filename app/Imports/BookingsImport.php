<?php

namespace App\Imports;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookingsImport implements ToModel, WithHeadingRow
{

    private $rowCount = 0;

    public function model(array $row)
    {

        // Skip row if mandatory fields are missing
        $userId = $row['user_id'] ?? null;

        // Only allow user_id if it exists, else set it to null
        if ($userId && !User::find($userId)) {
            $userId = null;
        }

        $this->rowCount++;

        return new Booking([
            'room_id' => $row['room_id'],
            'user_id' => $userId,
            'customer_name' => $row['customer_name'],
            'customer_email' => $row['customer_email'],
            'customer_phone' => $row['customer_phone'],
            'check_in_datetime' => Carbon::parse($row['check_in_datetime']),
            'check_out_datetime' => Carbon::parse($row['check_out_datetime']),
            'price' => $row['price'],
            'total_price' => $row['total_price'],
            'status' => $row['status'],
            'check_in_status' => $row['check_in_status'],
            'no_of_rooms' => $row['no_of_rooms'],
            'adults' => $row['adults'],
            'children' => $row['children'],
            'payment_status' => $row['payment_status'],
            'payment_type' => $row['payment_type'],
        ]);
    }


    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
