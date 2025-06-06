<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory, SoftDeletes;


    protected $guarded = [];

    // One-to-many relationship: RoomType has many Rooms
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
