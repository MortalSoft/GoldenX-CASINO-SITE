<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoomCity extends Model
{
    protected $table = 'boom_city';
    protected $fillable = ['user_id','coeff','login','bet','img'];
}
