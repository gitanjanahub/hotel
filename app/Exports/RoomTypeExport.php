<?php

namespace App\Exports;

use App\Models\RoomType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class RoomTypeExport implements FromCollection, WithHeadings, WithMapping
{
    protected $roomtypes;

    public function __construct(Collection $roomtypes)
    {
        $this->roomtypes = $roomtypes;
    }

    public function collection()
    {
        return $this->roomtypes;
    }

    public function map($roomtypes): array
    {
        return [
            $roomtypes->name,
            $roomtypes->rooms_count,
            $roomtypes->is_active ? 'Yes' : 'No',
            $roomtypes->created_at->format('d M Y, h:i A'),
        ];
    }


    public function headings(): array
    {
        return ['Room Type Name', 'Rooms', 'Is Active', 'Created At'];
    }


}
