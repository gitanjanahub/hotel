<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * A Service belongs to many Rooms (through room_services).
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_services');
        //return $this->belongsToMany(Room::class, 'room_services', 'service_id', 'room_id')
        //->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeHome($query)
    {
        return $query->where('home_page', 1);
    }
}
