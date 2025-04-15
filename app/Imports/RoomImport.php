<?php

namespace App\Imports;

use App\Models\Room;
use App\Models\RoomService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RoomImport implements ToModel, WithHeadingRow
{
    private int $rowCount = 0;

    public function model(array $row)
    {
        $this->rowCount++;

        // Handle main image
        $imagePath = $this->moveImage($row['image'] ?? '', 'images/rooms/thumbnails/');

        // Handle home thumbnail
        $homeThumbPath = $this->moveImage($row['home_thumb'] ?? '', 'images/rooms/thumbnails/');

        // Handle multiple images
        $additionalImages = [];
        if (!empty($row['images'])) {
            $imageNames = explode(',', $row['images']);
            foreach ($imageNames as $imageName) {
                $path = $this->moveImage(trim($imageName), 'images/rooms/');
                if ($path) {
                    $additionalImages[] = $path;
                }
            }
        }

        // Create Room
        $room = Room::create([
            'name'             => $row['name'],
            'room_type_id'     => $row['room_type_id'],
            'price_per_night'  => $row['price_per_night'],
            'size'             => $row['size'],
            'capacity'         => $row['capacity'],
            'adults'           => $row['adults'],
            'children'         => $row['children'],
            'bed'              => $row['bed'],
            'available_rooms'  => $row['available_rooms'],
            'is_active'        => $row['is_active'] ?? 1,
            'description'      => $row['description'],
            'image'            => $imagePath,
            'home_thumb'       => $homeThumbPath,
            'images'           => json_encode($additionalImages),
        ]);

        // Attach room services (service_ids like "1|3|4")
        if (!empty($row['service_ids'])) {
            $serviceIds = explode(',', $row['service_ids']);
            foreach ($serviceIds as $serviceId) {
                RoomService::create([
                    'room_id' => $room->id,
                    'service_id' => trim($serviceId),
                    'is_active' => 1,
                ]);
            }
        }

        return $room;
    }

    private function moveImage(string $originalName, string $destinationDir): ?string
    {
        if (empty($originalName)) {
            return null;
        }

        $sourcePath = storage_path('app/tmp-room-images/' . $originalName);

        if (!file_exists($sourcePath)) {
            return null;
        }

        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = Str::uuid() . '.' . $extension;
        $destination = $destinationDir . $uniqueName;

        if (Storage::disk('public')->exists($destination)) {
            $uniqueName = Str::uuid() . '.' . $extension;
            $destination = $destinationDir . $uniqueName;
        }

        Storage::disk('public')->put($destination, file_get_contents($sourcePath));
        unlink($sourcePath);

        return $destination;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
