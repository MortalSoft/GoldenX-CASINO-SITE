<?php

namespace App\Http\Controllers;

use App\Setting;
use App\X100;
use Auth;
use App\X100Anti;
use App\User;
use DB;
use App\ResultRandom;
use App\RandomKey;
use Illuminate\Http\Request;
use Redis;

class X100Controller extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function go(Request $request)
    {
        $color = $request->coff;
        
        

        $set = Setting::first();
        $arr = [2, 3, 10, 15, 20, 100];

        if (!in_array($color, $arr))
        {
            return response(['success' => false, 'mess' => 'Ошибка']);
        }

        if (!$set->status_x100)
        {
            
            $set->win_x100 = $color;
            $set->save();
            return response(['success' => true, 'mess' => 'Подкрутка на x' . $color]);
        }
        else
        {
            return response(['success' => false, 'mess' => 'Идет раунд, нельзя крутить']);
        }
    }

    public function bonusGo(Request $r){
        $user_id = $r->user_id;
        $avatar = $r->avatar;
        $set = Setting::first();
        if (!$set->status_x100)
        {
            
            $set->X100BonusUser_ID = $user_id;
            $set->X100BonusAvatar = $avatar;
            $set->save();
            return response(['success' => true, 'mess' => 'Бонуска успешно подкручена']);
        }
        else
        {
            return response(['success' => false, 'mess' => 'Идет раунд, нельзя крутить']);
        }
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
            'max' => 99,
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
        //return dd($out);
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
         0 => "20",
         1 => "2",
         2 => "3",
         3 => "2",
         4 => "15",
         5 => "2",
         6 => "3",
         7 => "2",
         8 => "20",
         9 => "2",
         10 => "15",
         11 => "2",
         12 => "3",
         13 => "2",
         14 => "3",
         15 => "2",
         16 => "15",
         17 => "2",
         18 => "3",
         19 => "10",
         20 => "3",
         21 => "2",
         22 => "10",
         23 => "2",
         24 => "3",
         25 => "2",

         26 => "100",
         27 => "2",
         28 => "3",
         29 => "2",
         30 => "10",
         31 => "2",
         32 => "3",
         33 => "2",
         34 => "3",
         35 => "2",
         36 => "15",
         37 => "2",
         38 => "3",
         39 => "2",
         40 => "3",
         41 => "2",
         42 => "20",
         43 => "2",
         44 => "3",
         45 => "2",
         46 => "10",
         47 => "2",
         48 => "3",
         49 => "2",
         50 => "10",

         51 => "2",
         52 => "3",
         53 => "2",
         54 => "15",
         55 => "2",
         56 => "3",
         57 => "2",
         58 => "3",
         59 => "2",
         60 => "10",
         61 => "20",
         62 => "3",
         63 => "2",
         64 => "3",
         65 => "2",
         66 => "15",
         67 => "2",
         68 => "10",
         69 => "2",
         70 => "3",
         71 => "2",
         72 => "20",
         73 => "2",
         74 => "3",
         75 => "2",

         76 => "15",
         77 => "2",
         78 => "3",
         79 => "2",
         80 => "10",
         81 => "2",
         82 => "3",
         83 => "2",
         84 => "3",
         85 => "2",
         86 => "10",
         87 => "2",
         88 => "3",
         89 => "2",
         90 => "3",
         91 => "2",
         92 => "10",
         93 => "2",
         94 => "3",
         95 => "2",
         96 => "3",
         97 => "2",
         98 => "3",
         99 => "2"
     );

        $setting = Setting::first();


        $result = self::randNumber();
        $rand = $result['result']['random']['data']['0'];
        $random = json_encode($result['result']['random']);
        $signature = $result['result']['signature'];
        $resultat = $doubleData[$rand];

        // $rand = rand(0, 99);
        // $random = '';
        // $signature = '';
        // $resultat = $doubleData[$rand];

        $wheel_win = $setting->win_x100;
        $coeff_bonus  = $setting->coeff_bonus;
        $auto_wheel = $setting->auto_x100;
        $youtube = $setting->youtube;

        if($wheel_win != 'false'){
            ////// подкрутка
            $resultat = $wheel_win;

            $massiv = range(0, 99);
            shuffle($massiv);
            $rand = self::searchNumber($doubleData, $massiv, $resultat);      
        }


        if($youtube == 0){        


            if($wheel_win == 'false'){           
                /// антинимиус 
                $max_win = X100Anti::where('coeff', $resultat)->first()->win;

                if($max_win > 500){
                    $wheel_anti_success = X100Anti::where('win', '<', 500)->orderByRaw("RAND()")->get();
                    if(count($wheel_anti_success) == 0){
                        $wheel_anti_success = X100Anti::orderBy('win', 'asc')->get();
                    }
                    $resultat = $wheel_anti_success[0]->coeff;

                }

                $massiv = range(0, 99);
                shuffle($massiv);
                $rand = self::searchNumber($doubleData, $massiv, $resultat);   

            }

        }
        
        $setting->win_x100 = 'false';
        $setting->save();


        return array(
            'number' => $rand,
            'signature' => $signature,
            'random' => $random,
        );
    }

      public function winWheel(Request $r){
        $setting = Setting::first();
        $wheelWinNumber = $setting->x100WinNumber;
        $X100BonusUser_ID = $setting->X100BonusUser_ID;
        $wheel = X100::where('coff', $wheelWinNumber)->get();
        foreach ($wheel as $w) {
            $user_id = $w->user_id;
            $bet = $w->bet;

            $unmWin = 1;
            $text_win = 'Выигрыш в X100 на x'.$wheelWinNumber;

            if($X100BonusUser_ID == $user_id){
                $unmWin = 4;
                $text_win = 'Выигрыш в X100 на x'.$wheelWinNumber.'. Бонус 4x';
            }
            $user = User::where('id', $user_id)->first();

            $win = $bet * $wheelWinNumber * $unmWin;

            $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

            if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

            $hist_balance = array(
                'user_id' => $user->id,
                'type' => $text_win,
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
        $wheelLose = X100::where('coff', '!=', $wheelWinNumber)->get();
        foreach ($wheelLose as $w) {
            $user_id = $w->user_id;
            $user = User::where('id', $user_id)->first();
            $user->lose_games += 1;
            $user->save();
        }

        return true;

    }

    public function get()
    {
        $wheel = X100::all();
        $colors = [2, 3, 10, 15, 20, 100];
        $arr = [];
        for ($i = 0;$i < count($colors);$i++)
        {
            $info = X100::where(['coff' => $colors[$i]])->get();
            $arr[] = ['coff' => $colors[$i], 'players' => collect($info)->unique('user_id')
            ->count() , 'sum' => $info->sum('bet')];
        }

        $history = DB::table('x100_history')->select(['id', 'coff', 'number', 'random', 'signature'])
        ->orderBy('id', 'desc')
        ->take('50')
        ->get();

        return response(['success' => $wheel, 'info' => $arr, 'history' => $history]);
    }

    public function bet(Request $r)
    {

        //return response(['error' => 'Произошла неизвестная ошибка']);

        $coff = $r->coff;
        $bet = round($r->bet, 2);

        $user = Auth::user();
        if($user->ban == 1){
            return response(['error' => 'Произошла неизвестная ошибка']);
        }
        $setting = Setting::first();
        if($user->admin != 1){
            // return response(['error' => 'Тех работы до 20:00 по МСК']);
        }
        if ($setting->status_x100)
        {
            return response(['error' => 'Ставки закрыты, ждите следующий раунд']);
        }

        if (\Cache::has('action.user.' . $user->id)) return response(['error' => 'Подождите 1 сек.']);
        \Cache::put('action.user.' . $user->id, '', 1);

        $balance = $user->balance;

        $mycoff = [2, 3, 10, 15, 20, 100];

        if (!in_array($coff, $mycoff))
        {
            return response(['error' => 'Произошла ошибка']);
        }

        

        if (X100::where(['user_id' => $user->id])->where('coff', '!=', $coff)->count() >= 3)
        {
            return response(['error' => 'Максимальное количество ставок 3']);
        }

        if ($bet < 1)
        {
            return response(['error' => 'Минимальная ставка 1 монета']);
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

        $auto_wheel = $setting->auto_x100;

        if($auto_wheel == 1){
            $wheel_anti = X100Anti::where('coeff', $coff)->first();
            $wheel_anti->win += ($bet * $coff);
            $wheel_anti->save();
        }

        
        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ставка в X100 на x'.$coff,
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
        $sum_wheel = X100::where(['coff' => $coff])->sum('bet');

        if(X100::where(['user_id' => $user->id, 'coff' => $coff])->count() == 0){
            X100::create(['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => $bet]);
            $info = X100::where(['coff' => $coff])->get();
            $bank = X100::sum('bet');
            $callback = ['data' => ['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => round($bet, 2), 'players' => collect($info)->unique('user_id')
        ->count() , 'sumBets' => $info->sum('bet')]];
            $this->redis->publish('x100Bet', json_encode($callback));
        }else{

            $x100 = X100::where(['user_id' => $user->id, 'coff' => $coff])->first();
            $x100->bet += $bet;
            $x100->save();
            $info = X100::where(['coff' => $coff])->get();
            $bank = X100::sum('bet');
            $callback = ['data' => ['user_id' => $user->id, 'coff' => $coff, 'img' => $user->avatar, 'login' => $user->name, 'bet' => round($x100->bet, 2), 'players' => collect($info)->unique('user_id')
        ->count() , 'sumBets' => $info->sum('bet')]];
            $this->redis->publish('updateX100Bet', json_encode($callback));
        }

        DB::commit();
$userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        

        return response(['success' => 'Ваша ставка принята', 'lastbalance' => $lastbalance, 'newbalance' => $userBalance, ]);

    }
}
