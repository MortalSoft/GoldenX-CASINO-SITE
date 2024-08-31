<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;
use App\Setting;
use App\BoomCity;

class BoomCityController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function get()
    {
        $wheel = BoomCity::all();
        $colors = [1, 2, 5, 'dice', 'lucky', 'boom'];
        $arr = [];
        for ($i = 0;$i < count($colors);$i++)
        {
            $info = BoomCity::where(['coeff' => $colors[$i]])->get();
            $arr[] = ['coeff' => $colors[$i], 'players' => collect($info)->unique('user_id')
            ->count() , 'sum' => $info->sum('bet')];
        }

        

        return response(['success' => $wheel, 'info' => $arr]);
    }
}
