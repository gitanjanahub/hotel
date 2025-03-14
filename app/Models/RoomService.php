<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomService extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * A RoomService belongs to a Room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * A RoomService belongs to a Service.
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
