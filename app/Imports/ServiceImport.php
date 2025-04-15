<?php

namespace App\Imports;

use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ServiceImport implements ToModel, WithHeadingRow
{
    private int $rowCount = 0;

    public function model(array $row)
    {

        $this->rowCount++;

        $imagePath = null;

        if (!empty($row['image'])) {
            $originalName = trim($row['image']);
            $sourcePath = storage_path('app/tmp-service-images/' . $originalName);

            if (file_exists($sourcePath)) {
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $uniqueName = Str::uuid() . '.' . $extension;  // Generate a unique name to avoid conflicts

                $destination = 'images/services/' . $uniqueName;

                // Check if the file already exists in the destination folder
                if (Storage::disk('public')->exists($destination)) {
                    // If file exists, rename the image to avoid conflict
                    $uniqueName = Str::uuid() . '.' . $extension;  // Regenerate the name
                    $destination = 'images/services/' . $uniqueName;
                }

                // Move the image to the public storage
                Storage::disk('public')->put($destination, file_get_contents($sourcePath));

                // Store the path in the database
                $imagePath = $destination;

                // Delete the image from the temporary folder after it is successfully imported
                unlink($sourcePath);  // Delete the temporary image file
            }
        }

        return new Service([
            'name'        => $row['name'],
            'description' => $row['description'] ?? null,
            'home_page'   => $row['home_page'] ?? 0,
            'image'       => $imagePath,
            'is_active'   => $row['is_active'] ?? 1,
        ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

}
