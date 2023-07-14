<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['name_room','maxperson','price','stock','image_id'];
}
