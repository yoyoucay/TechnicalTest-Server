<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $guarded = ['name_room','maxperson','price','stock','image_id','urlToImage'];

    protected $fillable = ['name_room','maxperson','price','stock','image_id','urlToImage'];

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}
