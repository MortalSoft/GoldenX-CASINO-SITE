<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['id','user_id', 'login','avatar', 'sum', 'data', 'transaction','beforepay','afterpay', 'status', 'percent', 'img_system'];
}
