<?php

namespace App\Imports;

use App\Models\RoomType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomtypeImport implements ToModel, WithHeadingRow
{
    private $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        return new RoomType([
            'name'        => $row['name'] ?? null,
            'description' => $row['description'] ?? null,
            'is_active'   => $row['is_active'] ?? 1,
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
