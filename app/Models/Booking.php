<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    // Room relationship: A Booking belongs to a Room
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // User relationship: A Booking belongs to a User (optional, only for registered users)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
