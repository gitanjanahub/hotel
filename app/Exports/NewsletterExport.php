<?php

namespace App\Exports;

use App\Models\Newsletter;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NewsletterExport implements FromCollection, WithHeadings, WithMapping
{


    protected $subscribers;

    // Accept data through constructor
    public function __construct(Collection $subscribers)
    {
        $this->subscribers = $subscribers;
    }

    public function collection()
    {
        return $this->subscribers;
    }

    public function map($row): array
    {
        return [
            $row->email,
            $row->created_at->format('d M Y, h:i A'), // Example: 08 Apr 2025, 12:32 PM
        ];
    }

    // public function collection()
    // {
    //     return Newsletter::select('email', 'created_at')->get();
    // }

    public function headings(): array
    {
        return ['Email', 'Subscribed At'];
    }
}

