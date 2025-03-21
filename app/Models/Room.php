<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Cast the 'services' and 'images' columns to arrays
    protected $casts = [
        //'services' => 'array',
        'images' => 'array',
    ];

     /**
     * A Room belongs to a RoomType.
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * A Room belongs to many Services (through room_services).
     */
    public function roomServices()
    {
        return $this->belongsToMany(Service::class, 'room_services');
        //return $this->belongsToMany(Service::class, 'room_services', 'room_id', 'service_id')
        //->withTimestamps();
    }

    // Room has many bookings (a room can have multiple bookings)
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }


    /**
     * Boot method to handle model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            $room->slug = static::generateUniqueSlug($room->name);
        });

        static::updating(function ($room) {
            if ($room->isDirty('name')) { // Only update slug if the name changes
                $room->slug = static::generateUniqueSlug($room->name);
            }
        });
    }

    /**
     * Generate a unique slug with a random identifier.
     */
    public static function generateUniqueSlug($name)
    {
        $slugBase = Str::slug($name);
        $uniqueId = substr(Str::uuid()->toString(), 0, 8); // Generate short unique ID
        $slug = $slugBase . '-' . $uniqueId;

        // Ensure uniqueness in case of collisions
        while (static::where('slug', $slug)->exists()) {
            $uniqueId = substr(Str::uuid()->toString(), 0, 8);
            $slug = $slugBase . '-' . $uniqueId;
        }

        return $slug;
    }
}





