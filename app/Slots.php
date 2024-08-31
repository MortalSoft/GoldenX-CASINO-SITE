<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Slots extends Model
{
    protected $table = 'slots';
    protected $guarded = [];
}
