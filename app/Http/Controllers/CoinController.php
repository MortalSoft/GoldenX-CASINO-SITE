<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Auth;
use App\User;
use App\Coin;
use Redis;

class CoinController extends Controller
{   
    public function finish(){
        $bank_game = \Cache::get('coinGame.bank') ?? 200;
        $profit_game = \Cache::get('coinGame.profit') ?? 0;

        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = Auth::user();

        $games_on = 0;
        if(\Cache::has('coinGame.user.'. $user->id.'start')) $games_on = \Cache::get('coinGame.user.'. $user->id.'start');
        if($games_on == 0) return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);

        // $game = Coin::where('user_id', $user->id)->first();
        $cache_gameCoin = \Cache::get('coinGame.user.'. $user->id.'game');
        $game = json_decode($cache_gameCoin);

        if($game->step < 1){
            return response(['success' => false, 'mess' => 'Вы не прошли ни один уровень' ]);
        }

        $win = $game->bet * $game->coeff;
        $setting = Setting::first();
        if($user->type_balance == 0){
            \Cache::put('coinGame.bank', $bank_game - $win);
                
             
        }

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;


        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Выигрыш в Coin',
            'balance_before' => $userBalance,
            'balance_after' => $userBalance + $win,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $lastbalance = $userBalance;
        $newbalance = $userBalance + $win;
        // $user->balance += $win;
        $user->type_balance == 0 ? $user->balance += $win : $user->demo_balance += $win;

        $user->count_win += 1;

        $user->sum_bet += $game->bet;
        $user->win_games += 1;
        $user->sum_win += $win;
        $user->minesStart = 0;
        if($user->max_win < $win){
            $user->max_win = $win;
        }

        $sumW = $win - $game->bet;
            $user->sum_to_withdraw -= $sumW;


        $user->save();

        $callback = array(
            'icon_game' => 'coinflip',
            'name_game' => 'Coin Flip',
            'avatar' => $user->avatar,
            'name' => $user->name,
            'bet' => round($game->bet, 2),
            'win' => round($win, 2)
        );

        $this->redis->publish('history', json_encode($callback));

        $bets = \Cache::get('games');
        $bets = json_decode($bets);
        $bets[] = $callback;
        $bets = array_slice($bets, -10, 10);

        $bets = json_encode($bets);

        \Cache::put('games', $bets);
        $coeffBonusCoin = $game->coeffBonusCoin;

       \Cache::put('coinGame.user.'. $user->id.'game', '');
        \Cache::put('coinGame.user.'. $user->id.'start', 0);

        // $game->delete();

        return response(['success' => 'Вы выиграли '.round($win, 2), 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'coeffBonusCoin'=>$coeffBonusCoin]);
    }

    public function play(Request $r){
        //return response(['error' => 'Произошла неизвестная ошибка. Обновите страницу']);
        $bank_game = \Cache::get('coinGame.bank') ?? 200;
        $profit_game = \Cache::get('coinGame.profit') ?? 0;

        // return response(['success' => false, 'mess' => 'Время работать :)']);
        $type = $r->type;

        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        $games_on = 0;
        if(\Cache::has('coinGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('coinGame.user.'. $user->id.'start');
        }
        if($games_on == 0){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }
        // $game = Coin::where('user_id', $user->id)->first();

        $cache_gameCoin = \Cache::get('coinGame.user.'. $user->id.'game');
        $game = json_decode($cache_gameCoin);

        $setting = Setting::first();

        // BONUS

        $sum_bet = $game->bet;
        $bonus = 0;
        $ikses = [];

        if($user->type_balance == 1){
            $r = rand(1, 50);
            if($r == 1){
                $bonus = 1;
            }
        }else{
            $r = rand(1, 80);
            if($r == 1){
                $bonus = 1;
            }
        }

        $userBonus = 0;

        if($bonus == 0){
            $bonus = $user->bonusCoin;
            $userBonus = 1;
            $user->bonusCoin = 0;
        }

        $user->save();

        $coeffBonusCoin = 1;

        if($bonus == 1){
            
            for ($i=0; $i < 60; $i++) { 
                $ikses[] = rand(2, 4);
            }

            $coeffBonusCoin = rand(2, 4);
            $ikses[43] = $coeffBonusCoin;

            if($userBonus == 0 && $user->type_balance == 0){
                if($game->coeff * $sum_bet * $coeffBonusCoin > $bank_game){
                    $bonus = 0;
                }
            }
        }

        $sum_bet *= $coeffBonusCoin;

        if($bonus == 1){
            $game->coeffBonusCoin = $coeffBonusCoin;
            $game->bonusCoin = json_encode($ikses);
            $game->bet = $sum_bet;

            \Cache::put('coinGame.user.'. $user->id.'game', json_encode($game));

            return response(['success' => true, 'off' => 3, 'coeffBonusCoin'=>$coeffBonusCoin, 'bonusCoin' => $ikses, 'win' => $game->coeff * $sum_bet]);
            
        }

        // END BONUS

        $side = rand(1, 2);

        if($user->type_balance == 1){
            $side_r = rand(1, 100);
            if($side_r < 40){
                $side = 1;
            }
            if($side_r < 60 && $side_r > 40){
                $side = $type;
            }
            if($side_r > 60){
                $side = 2;
            }
        }



        if($side == $type && $user->type_balance == 0){

            if($game->coeff == 0){
                $coeff = 1.95;
            }else{
                $coeff = $game->coeff * 2;
            }

            if($coeff * $game->bet > $bank_game){
                if($type == 1){ $side = 2; }else{ $side = 1;}   
            }
        }
        if($side == $type){
            // WIN
            if($game->coeff == 0){
                $game->coeff = 1.95;
            }else{
                $game->coeff *= 2;
            }
            $game->step += 1;

             \Cache::put('coinGame.user.'. $user->id.'game', json_encode($game));
            // $game->save();

            return response(['success' => true, 'off' => 0, 'type' => $side, 'win' => $game->coeff * $game->bet,  'coeff' => $game->coeff, 'step' => $game->step]);
        }else{
            // LOSE
            $callback = array(
                'icon_game' => 'coinflip',
                'name_game' => 'Coin Flip',
                'avatar' => $user->avatar,
                'name' => $user->name,
                'bet' => round($game->bet, 2),
                'win' => 0
            );

            $this->redis->publish('history', json_encode($callback));

            $bets = \Cache::get('games');
            $bets = json_decode($bets);
            $bets[] = $callback;
            $bets = array_slice($bets, -10, 10);

            $bets = json_encode($bets);

            \Cache::put('games', $bets);
            $coeffBonusCoin = $game->coeffBonusCoin;

            \Cache::put('coinGame.user.'. $user->id.'game', '');
            \Cache::put('coinGame.user.'. $user->id.'start', 0);

            // $game->delete();

            $user->lose_games += 1;
            $user->sum_to_withdraw -= $game->bet;
            $user->save();
            return response(['success' => true, 'off' => 1, 'type' => $side, 'coeffBonusCoin' => $coeffBonusCoin]);
        }

    }
    public function get(){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        $games_on = 0;
        if(\Cache::has('coinGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('coinGame.user.'. $user->id.'start');
        }
        if($games_on == 0){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }
        // $game = Coin::where('user_id', $user->id)->first();

        $cache_gameCoin = \Cache::get('coinGame.user.'. $user->id.'game');
        $game = json_decode($cache_gameCoin);

        return response(['success' => true, 'bet' => $game->bet, 'coeff' => $game->coeff, 'step' => $game->step, 'coeffBonusCoin'=>$game->coeffBonusCoin, 'bonusCoin' => $game->bonusCoin]);
    }
    public function bet(Request $r){
        $bank_game = \Cache::get('coinGame.bank') ?? 200;
        $profit_game = \Cache::get('coinGame.profit') ?? 0;

        $bet = $r->bet;
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        if($user->ban == 1){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }
        if (\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите 1 сек.']);
        \Cache::put('action.user.' . $user->id, '', 1);

        $games_on = 0;
        if(\Cache::has('coinGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('coinGame.user.'. $user->id.'start');
        }

        if($games_on > 0){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }

        if($bet < 1) return response(['error'=>'Минимальная сумма ставки 1']);

        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        if($userBalance < $bet) return response(['error'=>'Недостаточно средств']);

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ставка в Coin',
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
        $newbalance = $userBalance - $bet;

        $user->type_balance == 0 ? $user->balance -= $bet : $user->demo_balance -= $bet;
        $user->sum_bet += $bet;
        

        if ($user->type_balance == 0){
            \Cache::put('coinGame.bank', $bank_game + (round($bet, 2) * 0.8));
            \Cache::put('coinGame.profit', $profit_game + (round($bet, 2) * 0.2));
        }

        $sum_bet = $bet;
        $bonus = 0;
        $ikses = [];

        if($user->type_balance == 1){
            $r = rand(1, 50);
            if($r == 1){
                $bonus = 1;
            }
        }else{
            $r = rand(1, 80);
            if($r == 1){
                $bonus = 1;
            }
        }

        if($bonus == 0){
            $bonus = $user->bonusCoin;
            $user->bonusCoin = 0;
        }

        $user->save();

        $coeffBonusCoin = 1;

        if($bonus == 1){
            
            for ($i=0; $i < 60; $i++) { 
                $ikses[] = rand(2, 4);
            }

            $coeffBonusCoin = rand(2, 4);
            $ikses[43] = $coeffBonusCoin;
        }

        $sum_bet *= $coeffBonusCoin;


        $coin = array(
            'user_id'=> $user->id,
            'bet'=> $sum_bet,
            'bonusCoin'=> json_encode($ikses),
            'coeffBonusCoin'=> $coeffBonusCoin,
            'coeff' => 0,
            'step' => 0
        );

        \Cache::put('coinGame.user.'. $user->id.'start', 1);

        \Cache::put('coinGame.user.'. $user->id.'game', json_encode($coin));

        return response(['success'=>'Игра началась!', 'coeffBonusCoin'=>$coeffBonusCoin, 'bonusCoin' => $ikses, 'bonus' => $bonus,  'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);
    }
}
