<?php

namespace App\Exports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class ServiceExport implements FromCollection, WithHeadings, WithMapping
{
    // protected $search;

    // public function __construct($search = '')
    // {
    //     $this->search = $search;
    // }

    // public function collection(): Collection
    // {
    //     $query = Service::withCount('rooms');

    //     if (!empty($this->search)) {
    //         $query->where('name', 'like', '%' . $this->search . '%');
    //     }

    //     return $query->get()->map(function ($service) {
    //         return [
    //             'Name' => $service->name,
    //             'Rooms Count' => $service->rooms_count,
    //             'Created At' => $service->created_at->format('d M Y, h:i A'),
    //         ];
    //     });
    // }

    // public function headings(): array
    // {
    //     return ['Name', 'Rooms Count', 'Created At'];
    // }

    protected $services;

    public function __construct(Collection $services)
    {
        $this->services = $services;
    }

    public function collection()
    {
        return $this->services;
    }

    public function map($service): array
    {
        return [
            $service->name,
            $service->rooms_count,
            $service->home_page ? 'Yes' : 'No',
            $service->is_active ? 'Yes' : 'No',
            $service->created_at->format('d M Y, h:i A'),
        ];
    }


    public function headings(): array
    {
        return ['Name', 'Rooms', 'Homepage Display', 'Is Active', 'Created At'];
    }

}

