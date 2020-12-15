<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $guarded = [];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
