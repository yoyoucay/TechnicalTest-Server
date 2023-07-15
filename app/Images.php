<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $guarded = ['filename','type_file','size_file','user_id','description'];

    protected $fillable = ['filename','type_file','size_file','user_id','description'];
}
