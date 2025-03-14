<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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



}
