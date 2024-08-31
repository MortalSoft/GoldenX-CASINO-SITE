<?php
namespace App\Http\Controllers;

use App\Setting;
use App\Wheel;
use Auth;
use App\WheelAnti;
use App\User;
use DB;
use App\ResultRandom;
use App\RandomKey;
use Illuminate\Http\Request;
use Redis;


class WheelController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }
    public function get()
    {
        $wheel = Wheel::all();
        $colors = [2, 3, 5, 7, 14, 30];
        $arr = [];
        for ($i = 0;$i < count($colors);$i++)
        {
            $info = Wheel::where(['coff' => $colors[$i]])->get();
            $arr[] = ['coff' => $colors[$i], 'players' => collect($info)->unique('user_id')
            ->count() , 'sum' => $info->sum('bet') , ];
        }

        $history = DB::table('wheel_history')->select(['id', 'coff', 'number', 'random', 'signature'])
        ->orderBy('id', 'desc')
        ->take('50')
        ->get();

        return response(['success' => $wheel, 'info' => $arr, 'history' => $history, ]);
    }

    public function getKey() 
    {
        $MAX_RANDOM_KEY_ID = 13;
        $MIN_RANDOM_KEY_ID = 11;

        $setting = Setting::first();

        $l_key_id = $setting->random_key_id;
        $key_id = $l_key_id + 1;

        if ($key_id > $MAX_RANDOM_KEY_ID)
        {
            $key_id = $MIN_RANDOM_KEY_ID;
        }

        $setting->random_key_id = $key_id;
        $setting->save();

        $random_key = RandomKey::where('id', $key_id)->first();
        $key = $random_key->name_key;
        $random_key->games += 1;
        $random_key->save();

        return $key;

    }

    public function randNumber()
    {
        $key = self::getKey();

        $p = array(
            'apiKey' => "$key",
            'n' => 1,
            'min' => 0,
            'max' => 29,
            'replacement' => false,
        );
        $params = array(
            'jsonrpc' => "2.0",
            'method' => "generateSignedIntegers",
            'id' => 1,
            'params' => $p
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.random.org/json-rpc/1/invoke');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));
        $out = curl_exec($ch);
        curl_close($ch);

        return json_decode($out, true);
    }

    public function searchNumber($data, $massiv, $resultat){
        foreach ($massiv as $m) {
            if($data[$m] == $resultat){
                return $m;
            }
            unset($massiv[0]);
            $massiv = array_values($massiv);
        }
    }

    public function generateNumber()
    {

        $doubleData = array(
            0 => "30",
            1 => "7",
            2 => "3",
            3 => "2",
            4 => "3",
            5 => "2",
            6 => "5",
            7 => "3",
            8 => "2",
            9 => "5",
            10 => "2",
            11 => "14",
            12 => "2",
            13 => "3",
            14 => "2",
            15 => "bonus",
            16 => "7",
            17 => "5",
            18 => "2",
            19 => "5",
            20 => "7",
            21 => "2",
            22 => "14",
            23 => "2",
            24 => "3",
            25 => "5",
            26 => "7",
            27 => "3",
            28 => "2",
            29 => "3"
        );

        $setting = Setting::first();


        $result = self::randNumber();
        $rand = $result['result']['random']['data']['0'];
        $random = json_encode($result['result']['random']);
        $signature = $result['result']['signature'];
        $resultat = $doubleData[$rand];

        // $rand = rand(0, 29);
        // $random = '';
        // $signature = '';
        // $resultat = $doubleData[$rand];

        // $rand = self::searchNumber($doubleData, $massiv, $resultat);

        $wheel_win = $setting->wheel_win;
        $coeff_bonus  = $setting->coeff_bonus;
        $auto_wheel = $setting->auto_wheel;
        $youtube = $setting->youtube;
        $wheelYmn = $setting->wheelYmn;

        if($wheel_win == 'false'){      
            $wheel_win = $coeff_bonus;
        } 



        if($wheel_win != 'false'){
            ////// подкрутка
            $resultat = $wheel_win;

            $massiv = range(0, 29);
            shuffle($massiv);
            $rand = self::searchNumber($doubleData, $massiv, $resultat);      
        }

if($wheel_win == 'false' and $resultat == 'bonus'){ 
                $resultat = 2;
                $massiv = range(0, 29);
                shuffle($massiv);
                $rand = self::searchNumber($doubleData, $massiv, $resultat);
            }
        if($youtube == 0){          

            if($wheel_win == 'false' and $resultat == 'bonus'){ 
                $resultat = 2;
                $massiv = range(0, 29);
                shuffle($massiv);
                $rand = self::searchNumber($doubleData, $massiv, $resultat);
            }
            if($wheel_win == 'false' and $resultat != 'bonus'){           
                /// антинимиус 
                $max_win = WheelAnti::where('coeff', $resultat)->first()->win * $wheelYmn;

                if($max_win > 500){
                    $wheel_anti_success = WheelAnti::orderBy('win', 'asc')->first();
                    $resultat = $wheel_anti_success->coeff;
                }

                $massiv = range(0, 29);
                shuffle($massiv);
                $rand = self::searchNumber($doubleData, $massiv, $resultat);   

            }

        }
        


        $setting->wheel_win = 'false';
        $setting->save();


        return array(
            'number' => $rand,
            'signature' => $signature,
            'random' => $random,
        );
    }

    public function go(Request $request)
    {
        $color = $request->coff;
        if ($color == 'bonus')
        {
            $coeff_bonus = $request->coeff_bonus;
            $mult_bonus = $request->mult_bonus;
        }
        

        $set = Setting::first();
        $arr = [2, 3, 5, 7, 14, 30, 'bonus'];

        if (!in_array($color, $arr))
        {
            return response(['success' => false, 'mess' => 'Ошибка']);
        }

        if (!$set->status_wheel)
        {
            if ($color == 'bonus')
            {
                if ($coeff_bonus >= 2)
                {
                    $set->coeff_bonus = $coeff_bonus;
                }
                if ($mult_bonus != 0)
                {
                    $set->mult_bonus = $mult_bonus;
                }
            }
            $set->wheel_win = $color;
            $set->save();
            return response(['success' => true, 'mess' => 'Подкрутка на x' . $color]);
        }
        else
        {
            return response(['success' => false, 'mess' => 'Идет раунд, нельзя крутить']);
        }
    }

    public function winWheel(Request $r){
        $setting = Setting::first();
        $wheelYmn = $setting->wheelYmn;
        $wheelWinNumber = $setting->wheelWinNumber;

        $wheel = Wheel::where('coff', $wheelWinNumber)->get();
        foreach ($wheel as $w) {
            $user_id = $w->user_id;
            $bet = $w->bet;

            $user = User::where('id', $user_id)->first();

            $win = $bet * $wheelWinNumber * $wheelYmn;

            $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

            if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

            $hist_balance = array(
                'user_id' => $user->id,
                'type' => 'Выигрыш в Wheel на x'.$wheelWinNumber.' Multipleer x'.$wheelYmn,
                'balance_before' => $userBalance,
                'balance_after' => $userBalance + $win,
                'date' => date('d.m.Y H:i')
            );

            $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

            $cashe_hist_user = json_decode($cashe_hist_user);
            $cashe_hist_user[] = $hist_balance;
            $cashe_hist_user = json_encode($cashe_hist_user);
            \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

            $user->win_games += 1;
            $user->sum_win += $win;
            if($user->max_win < $win ){
                $user->max_win = $win;
            }

            $setting->wheel_bank -= $win;
            $setting->save();

            $callback = ['user_id' => $user->id, 'lastbalance' => $userBalance, 'newbalance' => $userBalance + $win];

            // $user->balance += $win;
            $user->type_balance == 0 ? $user->balance += $win : $user->demo_balance += $win;
            $user->save(); 

            
            $this->redis->publish('updateBalance', json_encode($callback)); 



        }
        $wheelLose = Wheel::where('coff', '!=', $wheelWinNumber)->get();
        foreach ($wheelLose as $w) {
            $user_id = $w->user_id;
            $user = User::where('id', $user_id)->first();
            $user->lose_games += 1;
            $user->save();
        }

        return true;

    }
    public function bet(Request $r)
    {
        //return response(['error' => 'Произошла неизвестная ошибка. Обновите страницу']);
        $coff = $r->coff;
        $bet = round($r->bet, 2);

        $user = Auth::user();
        if($user->ban == 1){
            return response(['error' => 'Произошла неизвестная ошибка']);
        }
        $setting = Setting::first();
        if($user->admin != 1){
             // return response(['error' => 'Технические работы']);
        }
        if ($setting->status_wheel)
        {
            return response(['error' => 'Ставки закрыты, ждите следующий раунд']);
        }

        if (\Cache::has('action.user.' . $user->id)) return response(['error' => 'Подождите 1 сек.']);
        \Cache::put('action.user.' . $user->id, '', 1);

        $balance = $user->balance;

        $mycoff = [2, 3, 5, 7, 14, 30];

        if (!in_array($coff, $mycoff))
        {
            return response(['error' => 'Произошла ошибка']);
        }
        $user_min_50 = [21166, 23731, 4779, 26808, 31069, 32282, 32772, 8501, 21529];
        

        if (Wheel::where(['user_id' => $user->id])->where('coff', '!=', $coff)->count() >= 3)
        {
            return response(['error' => 'Максимальное количество ставок 3']);
        }

        if ($bet < 1)
        {
            return response(['error' => 'Минимальная ставка 1 монета']);
        }

        if(in_array($user->id, $user_min_50)){
            if ($bet < 50){
                return response(['error' => 'Минимальная ставка 50 монет']);
            }
        }


        if ($bet > 100000)
        {
            return response(['error' => 'Максимальная ставка 100000 монет']);
        }


        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        if ($bet > $userBalance)
        {
            return response(['error' => 'Недостаточно средств']);
        }

        $auto_wheel = $setting->auto_wheel;

        if($auto_wheel == 1){
            $wheel_anti = WheelAnti::where('coeff', $coff)->first();
            $wheel_anti->win += ($bet * $coff);
            $wheel_anti->save();
        }

        
        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ставка в Wheel на x'.$coff,
            'balance_before' => $userBalance,
            'balance_after' => $userBalance - $bet,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


        DB::beginTransaction(); 
        $lastbalance = $userBalance;

        $user->type_balance == 0 ? $user->balance -= $bet : $user->demo_balance -= $bet;
        // $user->balance -= $bet;
        $user->sum_bet += $bet;
        $user->sum_to_withdraw -= $bet;

        $user->save();

        if ($user->type_balance == 1)
        {

            $setting->youtube = 1;

        }else{
            $setting->wheel_bank += ($bet * 0.9);
            $setting->wheel_profit += ($bet * 0.1);  
        }

        $setting->save();

        $sum_wheel = 0;
        $sum_wheel = Wheel::where(['coff' => $coff])->sum('bet');

        if(Wheel::where(['user_id' => $user->id, 'coff' => $coff])->count() == 0){
            Wheel::create(['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => $bet]);
            $info = Wheel::where(['coff' => $coff])->get();
            $callback = ['data' => ['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => round($bet, 2), 'players' => collect($info)->unique('user_id')
        ->count() , 'sumBets' => $info->sum('bet')]];
            $this->redis->publish('wheelBet', json_encode($callback));
        }else{

            $x30 = Wheel::where(['user_id' => $user->id, 'coff' => $coff])->first();
            $x30->bet += $bet;
            $x30->save();
            $info = Wheel::where(['coff' => $coff])->get();
            $callback = ['data' => ['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => round($x30->bet, 2), 'players' => collect($info)->unique('user_id')
        ->count() , 'sumBets' => $info->sum('bet')]];
            $this->redis->publish('updateWheelBet', json_encode($callback));
        }



        DB::commit();

$userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        return response(['success' => 'Ваша ставка принята', 'lastbalance' => $lastbalance, 'newbalance' => $userBalance]);

    }

}

