<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['game', 'login', 'sum','win_summa','user_id','type','id'];
}
