<?php

namespace App\Exports;

use App\Models\Room;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RoomExport implements FromCollection, WithHeadings, WithMapping
{
    protected $rooms;

    public function __construct(Collection $rooms)
    {
        $this->rooms = $rooms;
    }

    public function collection()
    {
        return $this->rooms;
    }

    public function map($room): array
    {
        return [
            $room->name,
            optional($room->roomType)->name,
            $room->roomServices->pluck('name')->implode(', '),
            $room->is_active ? 'Yes' : 'No',
            $room->created_at->format('d M Y, h:i A'),
        ];
    }

    public function headings(): array
    {
        return ['Room Name', 'Room Type', 'Services', 'Is Active', 'Created At'];
    }
}
