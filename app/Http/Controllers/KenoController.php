<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Setting;
use App\Keno;
use Auth;
use App\KenoHisroty;
use App\User;
use DB;
use Redis;
class KenoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function bonusGo(Request $r){
        $kenoBonusCoeff = $r->kenoBonusCoeff ?? 0;
        $kenoBonusNumber = $r->kenoBonusNumber ?? 0;

        $set = Setting::first();
        if (!$set->status_keno)
        {
            $set->numberBonusKeno = $kenoBonusNumber;
            $set->youtube_keno = 1;
            $set->coeffBonusKeno = $kenoBonusCoeff;
            $set->save();
            return response(['success' => true, 'mess' => 'Подкрутка OK']);
        }
        else
        {
            return response(['success' => false, 'mess' => 'Идет раунд, нельзя крутить']);
        }
    }


    public function go(Request $r){
        $kenoGo1 = $r->kenoGo1 ?? 0;
        $kenoGo2 = $r->kenoGo2 ?? 0;
        $kenoGo3 = $r->kenoGo3 ?? 0;
        $kenoGo4 = $r->kenoGo4 ?? 0;
        $kenoGo5 = $r->kenoGo5 ?? 0;
       

        $set = Setting::first();
        if (!$set->status_keno)
        {
            $kenoGo = [$kenoGo1, $kenoGo2, $kenoGo3, $kenoGo4, $kenoGo5];

            $value_to_delete = 0; //Элемент с этим значением нужно удалить
            $kenoGo = array_flip($kenoGo); //Меняем местами ключи и значения
            unset ($kenoGo[$value_to_delete]) ; //Удаляем элемент массива
            $kenoGo = array_flip($kenoGo); //Меняем местами ключи и значения

            $set->keno_numbers = json_encode($kenoGo);
            $set->youtube_keno = 1;
            $set->save();
            return response(['success' => true, 'mess' => 'Подкрутка OK']);
        }
        else
        {
            return response(['success' => false, 'mess' => 'Идет раунд, нельзя крутить']);
        }
        
    }

    public function winKeno(){
        $setting = Setting::first();

        $kenoNumbers = json_decode($setting->keno_numbers);
        $numberBonusKeno = $setting->numberBonusKeno;
        $coeffBonusKeno = $setting->coeffBonusKeno;

        $keno = Keno::all();

        $kenoCoefs = [[5.92],
[3.6, 9.6],
[2.2, 5.3, 100],
[1.5, 3.24, 20, 200],
[1.1, 2.8, 7.5, 28, 780]];

        foreach ($keno as $k) {
            $numbersUser = json_decode($k->numbers);
            $bet = $k->bet;
            $user_id = $k->user_id;

            $user = User::where('id', $user_id)->first();

            $itogMassiv = array_intersect($kenoNumbers, $numbersUser);

            if(count($itogMassiv) == 0){
                $user->lose_games += 1;
                $user->save();
            }else{

                $winUser = $kenoCoefs[count($numbersUser) - 1][count($itogMassiv) - 1];

                if (in_array($numberBonusKeno, $itogMassiv)){
                    $winUser *= $coeffBonusKeno;
                }
                $text_win = 'Выигрыш в Keno - x'.$winUser;

                $win = $bet * $winUser;

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

                $callback = ['user_id' => $user->id, 'lastbalance' => $userBalance, 'newbalance' => $userBalance + $win];

            // $user->balance += $win;
                $user->type_balance == 0 ? $user->balance += $win : $user->demo_balance += $win;
                $user->save();  

                $this->redis->publish('updateBalance', json_encode($callback)); 

                $callback = ['user_id' => $user->id, 'win' => $win];

                $this->redis->publish('kenoWin', json_encode($callback)); 

          
            }
        }

         return true;
    }


    public function get()
    {
        $bank = Keno::sum('bet');
        $users = Keno::count();
        if(\Auth::guest()){return response(['error' => 'Авторизуйтесь', 'bank' => $bank, 'users' => $users, 'history' => Keno::all() ]);}

        $user = \Auth::user();
        $keno = Keno::where('user_id', $user->id)->count();
        if($keno == 0){
            return response(['error' => 'Ошибка', 'bank' => $bank, 'users' => $users, 'history' => Keno::all()]);
        }
        $keno = Keno::where('user_id', $user->id)->first();
        $numbers = $keno->numbers;
        $bet = $keno->bet;



        return response(['success' => true, 'selects' => $numbers, 'bet' => $bet, 'bank' => $bank, 'users' => $users, 'history' => Keno::all()]);
    }

    public function bet(Request $r)
    {

        if(\Auth::guest()){return response(['error' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();


        if (\Cache::has('action.user.' . $user->id)) return response(['error' => 'Подождите 1 сек.']);
        \Cache::put('action.user.' . $user->id, '', 1);


        $selectsKeno = json_decode($r->selectsKeno);
        $countSelect = count($selectsKeno);

        $bet = $r->bet;

        $keno = Keno::where('user_id', $user->id)->count();
        if($keno != 0){
            return response(['error' => 'Вы уже сделали ставку']);
        }
        
        if($countSelect < 1 or $countSelect > 5){
            return response(['error' => 'Ошибка в выборе ячеек']);
        }
        if($user->ban == 1){
            return response(['error' => 'Произошла неизвестная ошибка']);
        }
        $setting = Setting::first();
        if($user->admin != 1){
            // return response(['error' => 'Тех работы до 20:00 по МСК']);
        }
        if ($setting->status_keno)
        {
            return response(['error' => 'Ставки закрыты, ждите следующий раунд']);
        }

        if($bet < 1){
            return response(['error' => 'Сумма ставки меньше 1' ]);
        }

        if(!is_numeric($bet)){
            return response(['error' => 'Введите сумму ставки корректно' ]);
        }

        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;


        if ($bet > $userBalance)
        {
            return response(['error' => 'Недостаточно средств']);
        }

        

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ставка в Keno',
            'balance_before' => $userBalance,
            'balance_after' => $userBalance - $bet,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $lastbalance = $userBalance;
        $user->type_balance == 0 ? $user->balance -= $bet : $user->demo_balance -= $bet;
        $user->sum_bet += $bet;
        $user->save();

        $kenoCoefs = [[5.92], [3.6, 9.6], [2.2, 5.3, 100], [1.5, 3.24, 20, 200], [1.1, 2.8, 7.5, 28, 780]];

        Keno::create(
            array(
                'user_id' => $user->id,
                'bet' => $bet,
                'numbers' => json_encode($selectsKeno),
                'login' => $user->name,
                'img' => $user->avatar,
                'win' => $winKeno = $bet * $kenoCoefs[count($selectsKeno) - 1][count($selectsKeno) - 1]
            ));

        $noVipad = [];
        if ($user->type_balance == 1){
            $setting->youtube_keno = 1;
        }else{
            

            for ($i=0; $i < count($selectsKeno); $i++) { 
                $winKeno = $bet * $kenoCoefs[count($selectsKeno) - 1][count($selectsKeno) - 1];
                if($winKeno > 500){
                    $noVipad[] = $selectsKeno[$i];
                }
            }
            
        }

        $noGetKeno = json_decode($setting->noGetKeno);

        $resultNoGetKeno = array_values(array_merge($noGetKeno, $noVipad));

        if(count($resultNoGetKeno) > 0){
            if($setting->youtube_keno == 0){
                // $setting->numberBonusKeno = $resultNoGetKeno[array_key_last($resultNoGetKeno)];
            }
        }

        
            $setting->noGetKeno = json_encode($resultNoGetKeno);
        
        $setting->save();

        $bank = Keno::sum('bet');
        $users = Keno::count();
        $callback = ['bank' => $bank, 'users' => $users, 'img' => $user->avatar, 'login' => $user->name, 'bet' => $bet, 'numbers' => json_encode($selectsKeno), 'win' => $winKeno = $bet * $kenoCoefs[count($selectsKeno) - 1][count($selectsKeno) - 1]];
        $this->redis->publish('updateKenoBank', json_encode($callback));
        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        return response(['success' => 'Ваша ставка принята', 'lastbalance' => $lastbalance, 'newbalance' => $userBalance ]);

    }
}
