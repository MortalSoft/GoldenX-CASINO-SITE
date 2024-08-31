<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redis;
use Auth;
use App\User;
use App\Shoot;
use App\Setting;
use App\Tourniers;
use App\TournierTable;

class ShootController extends Controller
{
    function selectGoodNumber($betsCrazy){
        $sumBetCrazyX1 = $betsCrazy['1'];
        $sumBetCrazyX2 = $betsCrazy['2'];
        $sumBetCrazyX5 = $betsCrazy['5'];
        $sumBetCrazyX10 = $betsCrazy['10'];
        $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
        $sumBetCrazyPachinko = $betsCrazy['pachinko'];
        $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
        $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

        $sumBetsCrazy = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;

        $crazyCoeffs = [
            5, 1, 2, 'pachinko', 1, 5, 1, 2, 1, 'coinflip', 1, 2, 1, 10, 2, 'cashhunt', 1, 2, 1, 5, 1, 'coinflip', 1, 5, 2, 10, 1, 'pachinko', 1, 2, 5, 1, 2, 'coinflip', 1, 10, 2, 5, 1, 'cashhunt', 1, 2, 5, 1, 2, 'coinflip', 2, 1, 10, 2, 1, 'crazytime', 1, 2, 'bonusX3', 'bonusX5'
        ];

        shuffle($crazyCoeffs);

        $setting = Setting::first();

        $shoot_bank = $setting->shoot_bank;

        foreach ($crazyCoeffs as $winNum) {
            if($winNum == 'pachinko'){
                if($sumBetCrazyPachinko * 40 < $shoot_bank or $sumBetCrazyPachinko == 0){
                    return $winNum;
                }
            }

            if($winNum == 'coinflip'){
                if($sumBetCrazyCoinflip * 4 < $shoot_bank or $sumBetCrazyCoinflip == 0){
                    return $winNum;
                }
            }

            if($winNum == 'cashhunt'){
                if($sumBetCrazyCashhunt * 10 < $shoot_bank or $sumBetCrazyCashhunt == 0){
                    return $winNum;
                }
            }

            if($winNum == 'crazytime'){
                if($sumBetCrazyCrazytime * 130 < $shoot_bank or $sumBetCrazyCrazytime == 0){
                    return $winNum;
                }
            }

            if($winNum == 'bonusX3'){
                if($sumBetsCrazy * 4 < $shoot_bank){
                    return $winNum;
                }
            }

            if($winNum == 'bonusX5'){
                if($sumBetsCrazy * 6 < $shoot_bank){
                    return $winNum;
                }
            }

            if($winNum == 1){
                if($sumBetCrazyX1 * 2 < $shoot_bank or $sumBetCrazyX1 == 0){
                    return $winNum;
                }
            }

            if($winNum == 2){
                if($sumBetCrazyX2 * 3 < $shoot_bank or $sumBetCrazyX2 == 0){
                    return $winNum;
                }
            }

            if($winNum == 5){
                if($sumBetCrazyX5 * 6 < $shoot_bank or $sumBetCrazyX5 == 0){
                    return $winNum;
                }
            }

            if($winNum == 10){
                if($sumBetCrazyX10 * 11 < $shoot_bank or $sumBetCrazyX10 == 0){
                    return $winNum;
                }
            }
        }

        return 1;
    }

    public function start(Request $r)
    {
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        $betsCrazy = $r->betsCrazy;

        $sumBetCrazyX1 = $betsCrazy['1'];
        $sumBetCrazyX2 = $betsCrazy['2'];
        $sumBetCrazyX5 = $betsCrazy['5'];
        $sumBetCrazyX10 = $betsCrazy['10'];
        $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
        $sumBetCrazyPachinko = $betsCrazy['pachinko'];
        $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
        $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

        $sumBets = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;

        if($user->ban == 1){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }
        if (\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите 1 сек.']);
        \Cache::put('action.user.' . $user->id, '', 1);


        $games_on = 0;
        if(\Cache::has('shootGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('shootGame.user.'. $user->id.'start');
        }


        if($games_on > 0){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }

        if($sumBets < 1){
            return response(['success' => false, 'mess' => 'Сумма ставки меньше 1' ]);
        }

        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        if($userBalance < $sumBets){
            return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
        }


        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ставка в Тире',
            'balance_before' => $userBalance,
            'balance_after' => $userBalance - $sumBets,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


        $lastbalance = $userBalance;

        $user->type_balance == 0 ? $user->balance -= $sumBets: $user->demo_balance -= $sumBets;
        $user->sum_bet += $sumBets;
        $user->sum_to_withdraw -= $sumBets;
        $user->save();

        $newbalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

        $crazyCoeffs = [
            5, 1, 2, 'pachinko', 1, 5, 1, 2, 1, 'coinflip', 1, 2, 1, 10, 2, 'cashhunt', 1, 2, 1, 5, 1, 'coinflip', 1, 5, 2, 10, 1, 'pachinko', 1, 2, 5, 1, 2, 'coinflip', 1, 10, 2, 5, 1, 'cashhunt', 1, 2, 5, 1, 2, 'coinflip', 2, 1, 10, 2, 1, 'crazytime', 1, 2, 'bonusX3', 'bonusX5'
        ];

        shuffle($crazyCoeffs);

        \Cache::put('shootGame.user.'. $user->id.'start', 1);

        $game = array(
            'user_id' => $user->id,
            'bets' => json_encode($betsCrazy),
            'type' => 0,
            'coeffs' => json_encode($crazyCoeffs),
            'cashHuntGame' => '[]',
            'crazyTimeGame' => '[]'
        );

        \Cache::put('shootGame.user.'. $user->id.'game', json_encode($game));


        if($user->type_balance == 0){
            $setting = Setting::first();
            
            $setting->shoot_bank += ($sumBets * 0.8);            
            $setting->shoot_profit += ($sumBets * 0.2);
            $setting->save();   
        }



        return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);
    }

    public function cashHuntGo(Request $r){

        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();


        $games_on = 0;
        if(\Cache::has('shootGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('shootGame.user.'. $user->id.'start');
        }
        if($games_on == 0){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }

        // $game = Shoot::where('user_id', $user->id)->first();

        $game = \Cache::get('shootGame.user.'. $user->id.'game');
        $game = json_decode($game);

        if($game->type != 4){
            return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
        }

        $selectCashHuntId = $r->selectCashHuntId;
        if($selectCashHuntId == -1){
            return response(['success' => false, 'mess' => 'Выберите ячейку']);
        }
        if($selectCashHuntId < 0 || $selectCashHuntId > 107){
            return response(['success' => false, 'mess' => 'Ошибка']);
        }
        
        $betsCrazy = json_decode($game->bets, true);

        $sumBetCrazyX1 = $betsCrazy['1'];
        $sumBetCrazyX2 = $betsCrazy['2'];
        $sumBetCrazyX5 = $betsCrazy['5'];
        $sumBetCrazyX10 = $betsCrazy['10'];
        $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
        $sumBetCrazyPachinko = $betsCrazy['pachinko'];
        $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
        $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

        $sumBetsCrazy = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;


        $cashHuntCoeffs =  [5, 5, 5, 5, 5, 5, 5, 5, 5, 5, 5,
            7, 7, 7, 7, 7, 7, 7, 7, 7, 7,
            10, 10, 10, 10, 10, 10, 10,
            15, 15, 15, 15, 15,
            20, 20, 20,
            50, 50,
            100, 100,
            200, 300];

            $coeffs = [];

            for ($i=0; $i <= 107; $i++) { 
                $coeffs[] = $cashHuntCoeffs[rand(0, count($cashHuntCoeffs) - 1)];
            }

            $setting = Setting::first();
            $shoot_bank = $setting->shoot_bank;


            if($sumBetCrazyCashhunt * ($coeffs[$selectCashHuntId] + 1) > $shoot_bank and $user->type_balance == 0){
                $p = 1;
                foreach ($cashHuntCoeffs as $cc) {
                    if($sumBetCrazyCashhunt * ($cc + 1) < $shoot_bank){
                        $coeffs[$selectCashHuntId] = $cc;
                        break;
                    }
                } 

                if($p == 1){
                    $cc = 5;
                    $coeffs[$selectCashHuntId] = $cc;
                }
            }

            $winUser = $sumBetCrazyCashhunt * ($coeffs[$selectCashHuntId] + 1);

            $count_tourniers = Tourniers::where('game_id', 0)->where('status', 1)->count();
            if($count_tourniers > 0 && $user->type_balance == 0){
                $tournier = Tourniers::where('game_id', 0)->where('status', 1)->first();


                $count_tournier_table = TournierTable::where('user_id', $user->id)->where('tournier_id', $tournier->id)->count();
                if($count_tournier_table == 0){
                    TournierTable::create(array(
                        'tournier_id' => $tournier->id,
                        'user_id' => $user->id,
                        'avatar' => $user->avatar,
                        'name' => $user->name,
                        'scores' => $winUser
                    ));
                }else{
                    $tournier_table = TournierTable::where('user_id', $user->id)->where('tournier_id', $tournier->id)->first();
                    $tournier_table->scores += $winUser;
                    $tournier_table->save();

                }

            }

            $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;


            if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

            $hist_balance = array(
                'user_id' => $user->id,
                'type' => 'Выигрыш в Тире',
                'balance_before' => $userBalance,
                'balance_after' => $userBalance + $winUser,
                'date' => date('d.m.Y H:i')
            );

            $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

            $cashe_hist_user = json_decode($cashe_hist_user);
            $cashe_hist_user[] = $hist_balance;
            $cashe_hist_user = json_encode($cashe_hist_user);
            \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

            $callback = array(
                'icon_game' => 'hunt',
                'name_game' => 'Shoot',
                'avatar' => $user->avatar,
                'name' => $user->name,
                'bet' => round($sumBetsCrazy, 2),
                'win' => $winUser
            );

            $this->redis->publish('history', json_encode($callback));

            $bets = \Cache::get('games');
            $bets = json_decode($bets);
            $bets[] = $callback;
            $bets = array_slice($bets, -10, 10);

            $bets = json_encode($bets);

            \Cache::put('games', $bets);


            $lastbalance = $userBalance;
            $newbalance = $userBalance + $winUser;

            $user->type_balance == 0 ? $user->balance += $winUser : $user->demo_balance += $winUser;

            $user->save();

            // $game->delete();

            \Cache::put('shootGame.user.'. $user->id.'game', '');
            \Cache::put('shootGame.user.'. $user->id.'start', 0);


            if($user->type_balance == 0){
                $setting = Setting::first();

                $setting->shoot_bank -= $winUser; 
                $setting->save();   
            }


            return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'winUser' => $winUser, 'coeffs' => $coeffs]);
        }


        public function crazyStart(Request $r){

            if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

            $user = \Auth::user();


            $games_on = 0;
            if(\Cache::has('shootGame.user.'. $user->id.'start')){
                $games_on = \Cache::get('shootGame.user.'. $user->id.'start');
            }


            if($games_on == 0){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }

            // $game = Shoot::where('user_id', $user->id)->first();

            $game = \Cache::get('shootGame.user.'. $user->id.'game');
            $game = json_decode($game);

            if($game->type != 5){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }

            $number = round($r->number);

            if($number < 1 || $number > 3){
                return response(['success' => false, 'mess' => 'Ошибка']);
            }

            $coeffs = json_decode($game->crazyTimeGame, true)[0];

            $number_choose_site = rand(3, 59);
            $coeff_1 = $coeffs[$number_choose_site - 3];
            $coeff_2 = $coeffs[$number_choose_site];
            $coeff_3 = $coeffs[$number_choose_site + 3];



            if($number == 1 and $coeff_1 == 'double'){
                $number_choose_site = $number_choose_site + 1;

                $coeff_1 = $coeffs[$number_choose_site - 3];
                $coeff_2 = $coeffs[$number_choose_site];
                $coeff_3 = $coeffs[$number_choose_site + 3];


            }

            if($number == 2 and $coeff_2 == 'double'){
                $number_choose_site = $number_choose_site + 1;

                $coeff_1 = $coeffs[$number_choose_site - 3];
                $coeff_2 = $coeffs[$number_choose_site];
                $coeff_3 = $coeffs[$number_choose_site + 3];

            }

            if($number == 3 and $coeff_3 == 'double'){
                $number_choose_site = $number_choose_site + 1;

                $coeff_1 = $coeffs[$number_choose_site - 3];
                $coeff_2 = $coeffs[$number_choose_site];
                $coeff_3 = $coeffs[$number_choose_site + 3];


            }

            $rotate = (360 / 64 * ($number_choose_site)) + (360 / 64) + (rand(-30, 30) / 10);

            $betsCrazy = json_decode($game->bets, true);

            $sumBetCrazyX1 = $betsCrazy['1'];
            $sumBetCrazyX2 = $betsCrazy['2'];
            $sumBetCrazyX5 = $betsCrazy['5'];
            $sumBetCrazyX10 = $betsCrazy['10'];
            $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
            $sumBetCrazyPachinko = $betsCrazy['pachinko'];
            $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
            $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

            $sumBetsCrazy = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;


            if($number == 1){
                $winUser = ($coeff_1 + 1) * $sumBetCrazyCrazytime;
            }

            if($number == 2){
                $winUser = ($coeff_2 + 1) * $sumBetCrazyCrazytime;
            }

            if($number == 3){
                $winUser = ($coeff_3 + 1) * $sumBetCrazyCrazytime;
            }

            $count_tourniers = Tourniers::where('game_id', 0)->where('status', 1)->count();
            if($count_tourniers > 0 && $user->type_balance == 0){
                $tournier = Tourniers::where('game_id', 0)->where('status', 1)->first();


                $count_tournier_table = TournierTable::where('user_id', $user->id)->count();
                if($count_tournier_table == 0){
                    TournierTable::create(array(
                        'tournier_id' => $tournier->id,
                        'user_id' => $user->id,
                        'avatar' => $user->avatar,
                        'name' => $user->name,
                        'scores' => $winUser
                    ));
                }else{
                    $tournier_table = TournierTable::where('user_id', $user->id)->first();
                    $tournier_table->scores += $winUser;
                    $tournier_table->save();

                }

            }

            $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

            if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

            $hist_balance = array(
                'user_id' => $user->id,
                'type' => 'Выигрыш в Тире',
                'balance_before' => $userBalance,
                'balance_after' => $userBalance + $winUser,
                'date' => date('d.m.Y H:i')
            );

            $callback = array(
                'icon_game' => 'hunt',
                'name_game' => 'Shoot',
                'avatar' => $user->avatar,
                'name' => $user->name,
                'bet' => round($sumBetsCrazy, 2),
                'win' => $winUser
            );

            $this->redis->publish('history', json_encode($callback));

            $bets = \Cache::get('games');
            $bets = json_decode($bets);
            $bets[] = $callback;
            $bets = array_slice($bets, -10, 10);

            $bets = json_encode($bets);

            \Cache::put('games', $bets);

            $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

            $cashe_hist_user = json_decode($cashe_hist_user);
            $cashe_hist_user[] = $hist_balance;
            $cashe_hist_user = json_encode($cashe_hist_user);
            \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

            $lastbalance = $userBalance;
            $newbalance = $userBalance + $winUser;

            $user->type_balance == 0 ? $user->balance += $winUser : $user->demo_balance += $winUser;

            $user->save();

            // $game->delete();

            \Cache::put('shootGame.user.'. $user->id.'game', '');
            \Cache::put('shootGame.user.'. $user->id.'start', 0);

            if($user->type_balance == 0){
                $setting = Setting::first();

                $setting->shoot_bank -= $winUser; 
                $setting->save();   
            }

            return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'winUser' => $winUser, 'rotate' => $rotate, 'coeff_1' => $coeff_1, 'coeff_2' => $coeff_2, 'coeff_3' => $coeff_3]);

        }


        public function get(){
            if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

            $user = \Auth::user();

            $games_on = 0;
            if(\Cache::has('shootGame.user.'. $user->id.'start')){
                $games_on = \Cache::get('shootGame.user.'. $user->id.'start');
            }

            if($games_on == 0){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }

            // $game = Shoot::where('user_id', $user->id)->first();

            $game = \Cache::get('shootGame.user.'. $user->id.'game');
            $game = json_decode($game);
            
            $betsCrazy = json_decode($game->bets, true);

            $sumBetCrazyX1 = $betsCrazy['1'];
            $sumBetCrazyX2 = $betsCrazy['2'];
            $sumBetCrazyX5 = $betsCrazy['5'];
            $sumBetCrazyX10 = $betsCrazy['10'];
            $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
            $sumBetCrazyPachinko = $betsCrazy['pachinko'];
            $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
            $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

            $sumBetsCrazy = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;

            $type = $game->type;
            $cashHuntGame = json_decode($game->cashHuntGame, true);
            $coeffsCrazy = json_decode($game->crazyTimeGame, true);

            $colors = '';
            $coeffs = '';
            if($type == 5){
                $coeffs = $coeffsCrazy[1];
                $colors = $coeffsCrazy[2];
            }


            return response(['success' => true, 'type' => $type, 'betsCrazy' => $betsCrazy, 'sumBetsCrazy' => $sumBetsCrazy, 'cashHuntGame' => $cashHuntGame, 'coeffs' => $coeffs, 'colors' => $colors]);
        }

        public function go(Request $r)
        {
            //return response(['error' => 'Произошла неизвестная ошибка']);
            $number = $r->number;

            if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

            $user = \Auth::user();

            if($user->ban == 1){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }
        // if (\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите 1 сек.']);
            \Cache::put('action.user.' . $user->id, '', 1);


            $games_on = 0;
            if(\Cache::has('shootGame.user.'. $user->id.'start')){
                $games_on = \Cache::get('shootGame.user.'. $user->id.'start');
            }

            if($games_on == 0){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }

            // $game = Shoot::where('user_id', $user->id)->first();

            $game = \Cache::get('shootGame.user.'. $user->id.'game');
            $game = json_decode($game);

            if($game->type != 0){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }
            $betsCrazy = json_decode($game->bets, true);

            $sumBetCrazyX1 = $betsCrazy['1'];
            $sumBetCrazyX2 = $betsCrazy['2'];
            $sumBetCrazyX5 = $betsCrazy['5'];
            $sumBetCrazyX10 = $betsCrazy['10'];
            $sumBetCrazyCoinflip = $betsCrazy['coinflip'];
            $sumBetCrazyPachinko = $betsCrazy['pachinko'];
            $sumBetCrazyCashhunt = $betsCrazy['cashhunt'];
            $sumBetCrazyCrazytime = $betsCrazy['crazytime'];

            $sumBetsCrazy = $sumBetCrazyX1 + $sumBetCrazyX2 + $sumBetCrazyX5 + $sumBetCrazyX10 + $sumBetCrazyCoinflip + $sumBetCrazyPachinko + $sumBetCrazyCashhunt + $sumBetCrazyCrazytime;

            $crazyCoeffs = json_decode($game->coeffs, true);
            shuffle($crazyCoeffs);

            if($number > count($crazyCoeffs)){
                return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
            }
            $shootDropu = 0;
            if($user->shootDrop != '0'){
                $shootDropu = 1;
                $crazyCoeffs[$number] = $user->shootDrop;
                $user->shootDrop = '0';
                $user->save();
            }

            $setting = Setting::first();
            $shoot_bank = $setting->shoot_bank;
        // $crazyCoeffs[$number] = 'bonusX5';

            $game->coeffs = json_encode($crazyCoeffs);

            $winNumber = $crazyCoeffs[$number];

            if($user->type_balance == 0 and $shootDropu == 0){


                if($winNumber == 'pachinko' or $winNumber == 'coinflip' or $winNumber == 'crazytime' or $winNumber == 'cashhunt' or $winNumber == 'bonusX3' or $winNumber == 'bonusX5'){

                    if($winNumber == 'pachinko'){
                        if($sumBetCrazyPachinko * 15 > $shoot_bank and $sumBetCrazyPachinko > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 'coinflip'){
                        if($sumBetCrazyCoinflip * 4 > $shoot_bank and $sumBetCrazyCoinflip > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }  
                    }

                    if($winNumber == 'crazytime'){
                        if($sumBetCrazyCrazytime * 75 > $shoot_bank and $sumBetCrazyCrazytime > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 'cashhunt'){
                        if($sumBetCrazyCashhunt * 11 > $shoot_bank and $sumBetCrazyCashhunt > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 'bonusX3'){
                        if($sumBetsCrazy * 4 > $shoot_bank){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 'bonusX5'){
                        if($sumBetsCrazy * 6 > $shoot_bank){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                }else{
                    if($winNumber == 1){
                        if($sumBetCrazyX1 * 2 > $shoot_bank and $sumBetCrazyX1 > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 2){
                        if($sumBetCrazyX2 * 3 > $shoot_bank and $sumBetCrazyX2 > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 5){
                        if($sumBetCrazyX5 * 6 > $shoot_bank and $sumBetCrazyX5 > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }

                    if($winNumber == 10){
                        if($sumBetCrazyX10 * 11 > $shoot_bank and $sumBetCrazyX10 > 0){
                            $winNumber = $this->selectGoodNumber($betsCrazy);
                            $crazyCoeffs[$number] = $winNumber;
                        }
                    }
                }

            }

            if($winNumber == 'pachinko' or $winNumber == 'coinflip' or $winNumber == 'crazytime' or $winNumber == 'cashhunt' or $winNumber == 'bonusX3' or $winNumber == 'bonusX5'){
                if($winNumber == 'crazytime'){
                    if($sumBetCrazyCrazytime == 0){
                        // $game->delete();
                        \Cache::put('shootGame.user.'. $user->id.'game', '');
                        \Cache::put('shootGame.user.'. $user->id.'start', 0);
                        return response(['success' => true, 'type' => 0, 'crazyCoeffs' => $crazyCoeffs]);
                    }
                    $game->type = 5;


                    $coefficient =  [
                        15, 15,
                        20, 20, 20,
                        25, 25, 25,
                        30, 30, 30,
                        40, 40, 40, 40,
                        50, 50, 50, 50,
                        75, 75,
                        100, 100,
                        200, 200,
                        300,
                        400,
                        500,
                    ];

                    $coeffs = [];
                    $coeffs1 = [];
                    $colors = [];

                    for ($i=0; $i <= 63; $i++) { 
                        $colors[] = '';
                        $r = $coefficient[rand(0, count($coefficient) - 1)];
                        $coeffs[] = $r.'x';
                        $coeffs1[] = $r;
                    }

                    for ($i=0; $i <= 63; $i = $i + 8) { 
                        $coeffs[$i] = 'Double';
                        $colors[$i] = 'double';
                        $coeffs1[$i] = 'double';
                    }

                    for ($i=1; $i <= 64; $i = $i + 8) { 
                        $colors[$i] = 'lightpurple';
                    }

                    for ($i=2; $i <= 65; $i = $i + 8) { 
                        $colors[$i] = 'green';
                    }

                    for ($i=3; $i <= 66; $i = $i + 8) { 
                        $colors[$i] = 'lightblue';
                    }

                    for ($i=4; $i <= 67; $i = $i + 8) { 
                        $colors[$i] = 'turquoise';
                    }

                    for ($i=5; $i <= 68; $i = $i + 8) { 
                        $colors[$i] = 'red';
                    }

                    for ($i=6; $i <= 69; $i = $i + 8) { 
                        $colors[$i] = 'yellow';
                    }

                    for ($i=7; $i <= 70; $i = $i + 8) { 
                        $colors[$i] = 'lightyellow';
                    }

                    $game->crazyTimeGame = json_encode([$coeffs1, $coeffs, $colors]);
                    // $game->save();

                    \Cache::put('shootGame.user.'. $user->id.'game', json_encode($game));


                    return response(['success' => true, 'type' => 5, 'crazyCoeffs' => $crazyCoeffs, 'coeffs' => $coeffs, 'colors' => $colors]);
                }

                if($winNumber == 'cashhunt'){
                    if($sumBetCrazyCashhunt == 0){
                        // $game->delete();
                        \Cache::put('shootGame.user.'. $user->id.'game', '');
                        \Cache::put('shootGame.user.'. $user->id.'start', 0);
                        return response(['success' => true, 'type' => 0, 'crazyCoeffs' => $crazyCoeffs]);
                    }
                    $images = [];

                    for ($i=0; $i <= 107; $i++) { 
                        $images[] = rand(1, 6);
                    }

                    $game->cashHuntGame = json_encode($images);
                    $game->type = 4;

                    // $game->save();

                    \Cache::put('shootGame.user.'. $user->id.'game', json_encode($game));

                    return response(['success' => true, 'type' => 4, 'crazyCoeffs' => $crazyCoeffs, 'images' => $images]);

                }

                if($winNumber == 'pachinko'){
                    if($sumBetCrazyPachinko == 0){
                        // $game->delete();
                        \Cache::put('shootGame.user.'. $user->id.'game', '');
                        \Cache::put('shootGame.user.'. $user->id.'start', 0);
                        return response(['success' => true, 'type' => 0, 'crazyCoeffs' => $crazyCoeffs]);
                    }

                    $pachinkoPins = [
                        1 => [[1, 25], [4, 129], [5, 168], [7, 240], [7, 247]],
                        2 => [[1, 14], [1, 15], [1, 17], [1, 18], [1, 21], [1, 22], [2, 52], [2, 54], [2, 58], [2, 61], [3, 90], [3, 98], [4, 127], [4, 130], [5, 165], [6, 204], [8, 279], [8, 286], [11, 399]],
                        3 => [[1, 19], [1, 20], [2, 56], [2, 57], [2, 60], [3, 89], [3, 93], [4, 131], [5, 172], [7, 249]],
                        4 => [[1, 24], [3, 97], [4, 133], [4, 134], [5, 173], [5, 174], [6, 205], [6, 209], [8, 281], [9, 324]],
                        5 => [[1, 16], [2, 55], [2, 59], [4, 135], [6, 202], [6, 206], [6, 211], [8, 285], [9, 319], [12, 429], [15, 549]],
                        6 => [[2, 53], [3, 91], [3, 99], [4, 126], [4, 132], [4, 136], [6, 208], [9, 322], [11, 398], [13, 468]],
                        7 => [[2, 62], [3, 92], [3, 96], [5, 166], [5, 167], [7, 248], [8, 284], [9, 318], [9, 323], [10, 354], [10, 358], [13, 475]],
                        8 => [[1, 23], [3, 95], [5, 169], [6, 207], [6, 210], [7, 243], [8, 283], [9, 315], [9, 316], [10, 352], [11, 397], [13, 474]],
                        9 => [[4, 128], [7, 242], [7, 250], [10, 356], [10, 360], [12, 430], [12, 434], [12, 436]],
                        10 => [[5, 164], [5, 170], [5, 171], [6, 203], [7, 241], [7, 245], [8, 280], [9, 314], [10, 361], [12, 431], [13, 476], [14, 504], [14, 505], [14, 508], [16, 583], [16, 585]],
                        11 => [[6, 212], [8, 278], [10, 353], [11, 393], [12, 435], [12, 438], [13, 466], [13, 472], [15, 543], [15, 544], [16, 580]],
                        12 => [[3, 94], [7, 244], [8, 282], [9, 320], [10, 355], [10, 357], [11, 391], [11, 394], [12, 433], [14, 507], [16, 581], [16, 586], [16, 588]],
                        13 => [[9, 321], [10, 359], [11, 392], [14, 509], [15, 547], [16, 579]],
                        14 => [[9, 317], [11, 390], [11, 396], [12, 432], [13, 471], [14, 510], [14, 511], [15, 545], [15, 548], [15, 550], [16, 578], [16, 582]],
                        15 => [[7, 246], [10, 362], [11, 395], [11, 400], [12, 428], [12, 437], [13, 467], [13, 470], [13, 473], [14, 506], [14, 512], [15, 540], [15, 542], [15, 546], [16, 584], [16, 587]],
                        16 => [[13, 469], [15, 541]]

                    ];

                    $coeffs =  [5, 5, 5, 5, 5, 5, 5, 5,
                        7, 7, 7, 7, 7, 7,
                        10, 10, 10,
                        15, 15, 15,
                        20, 20, 20,
                        25, 25, 25,
                        40, 40, 40,
                        75, 75,
                        100,
                        200
                    ];
                // [куда => [[откуда, с какого расстояния], [откуда, с какого расстояния]]]
                    $pachinkoCoeffs = [];

                    for ($i=0; $i <= 15; $i++) { 
                        $pachinkoCoeffs[] = $coeffs[rand(0, count($coeffs) - 1)];
                    }


                    $go = rand(1, 16);

                    $setting = Setting::first();
                    $shoot_bank = $setting->shoot_bank;

                    $m = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
                    shuffle($m);

                    // if($user->type_balance == 0 and $sumBetCrazyPachinko > 0){
                    //     if($pachinkoCoeffs[$go - 1] * $sumBetCrazyPachinko > $shoot_bank){
                    //         foreach ($m as $cc) {
                    //             if($pachinkoCoeffs[$cc - 1] * $sumBetCrazyPachinko < $shoot_bank){
                    //                 $go = $cc;
                    //                 break;
                    //             }
                    //         }

                    //         $go = rand(1, 6);
                    //     }
                    // }

                    $pin = $pachinkoPins[$go];
                    $pin = $pin[rand(0, count($pin) - 1)];

                    $position_number = $pin[0];
                    $position = $pin[1];
                    $coeff = $pachinkoCoeffs[$go - 1];

                    if($coeff == 'Double'){
                        $coeff = $coeffs[rand(0, count($coeffs) - 2)];
                        $pachinkoCoeffs[$go - 1] = $coeff;
                    }

                    $winUser = $sumBetCrazyPachinko * ($coeff + 1);

                    $count_tourniers = Tourniers::where('game_id', 0)->where('status', 1)->count();
                    if($count_tourniers > 0 && $user->type_balance == 0){
                        $tournier = Tourniers::where('game_id', 0)->where('status', 1)->first();


                        $count_tournier_table = TournierTable::where('user_id', $user->id)->count();
                        if($count_tournier_table == 0){
                            TournierTable::create(array(
                                'tournier_id' => $tournier->id,
                                'user_id' => $user->id,
                                'avatar' => $user->avatar,
                                'name' => $user->name,
                                'scores' => $winUser
                            ));
                        }else{
                            $tournier_table = TournierTable::where('user_id', $user->id)->first();
                            $tournier_table->scores += $winUser;
                            $tournier_table->save();
                            
                        }

                    }

                    $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

                    $lastbalance = $userBalance;
                    $newbalance = $userBalance + $winUser;

                    $user->type_balance == 0 ? $user->balance += $winUser : $user->demo_balance += $winUser;

                    $user->save();

                    // $game->delete();

                    \Cache::put('shootGame.user.'. $user->id.'game', '');
                    \Cache::put('shootGame.user.'. $user->id.'start', 0);

                    if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

                    $hist_balance = array(
                        'user_id' => $user->id,
                        'type' => 'Выигрыш в Тире',
                        'balance_before' => $userBalance,
                        'balance_after' => $userBalance + $winUser,
                        'date' => date('d.m.Y H:i')
                    );

                    $callback = array(
                        'icon_game' => 'hunt',
                        'name_game' => 'Shoot',
                        'avatar' => $user->avatar,
                        'name' => $user->name,
                        'bet' => round($sumBetsCrazy, 2),
                        'win' => $winUser
                    );

                    $this->redis->publish('history', json_encode($callback));

                    $bets = \Cache::get('games');
                    $bets = json_decode($bets);
                    $bets[] = $callback;
                    $bets = array_slice($bets, -10, 10);

                    $bets = json_encode($bets);

                    \Cache::put('games', $bets);

                    $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

                    $cashe_hist_user = json_decode($cashe_hist_user);
                    $cashe_hist_user[] = $hist_balance;
                    $cashe_hist_user = json_encode($cashe_hist_user);
                    \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

                    if($user->type_balance == 0){
                        $setting = Setting::first();

                        $setting->shoot_bank -= $winUser; 
                        $setting->save();   
                    }


                    return response(['success' => true, 'type' => 3, 'crazyCoeffs' => $crazyCoeffs, 'pachinkoCoeffs' => $pachinkoCoeffs, 'position_number' => $position_number, 'position' => $position, 'coeff' => $coeff, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'winUser' => $winUser]);

                }
                if($winNumber == 'coinflip'){
                    if($sumBetCrazyCoinflip == 0){
                        // $game->delete();
                        \Cache::put('shootGame.user.'. $user->id.'game', '');
                        \Cache::put('shootGame.user.'. $user->id.'start', 0);
                        return response(['success' => true, 'type' => 0, 'crazyCoeffs' => $crazyCoeffs]);
                    }

                    $coeffsCoin = [2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2,
                       3, 3, 3, 3, 3, 3, 3, 3, 3, 3,
                       4, 4, 4, 4, 4, 4, 4,
                       5, 5, 5, 5, 5,
                       7, 7, 7, 7,
                       10, 10, 10,
                       15, 15, 15,
                       20, 20,
                       35, 35,
                       50,
                       70,
                       80,
                       90,
                       100];

                       $coeffsCoin1 = [
                           3, 3, 3, 3, 3, 3, 3, 3, 3, 3,
                           4, 4, 4, 4, 4, 4, 4,
                           5, 5, 5, 5, 5,
                           7, 7, 7, 7,
                           10, 10, 10,
                           15, 15, 15,
                           20, 20,
                           35, 35,
                           50,
                           70,
                           80,
                           90,
                           100];


                           $coin1Coeffs = [];
                           $coin2Coeffs = [];

                           for ($i=0; $i <= 100; $i++) { 
                            $randCoeff1 = $coeffsCoin1[rand(0, count($coeffsCoin1) - 1)];
                            $randCoeff2 = $coeffsCoin[rand(0, count($coeffsCoin) - 1)];

                            $coin1Coeffs[] = $randCoeff1;
                            $coin2Coeffs[] = $randCoeff2;
                        }

                        $reshkaCoeff = $coin1Coeffs[50];
                        $orelCoeff = $coin2Coeffs[50];

                        if($reshkaCoeff == $orelCoeff){
                            foreach ($coeffsCoin as $cc) {
                                if($cc != $reshkaCoeff){
                                    $orelCoeff = $cc;
                                    $coin2Coeffs[50] = $cc;
                                    break;
                                }
                            }
                        }

                        $winType = rand(1, 2);

                        if($winType == 1){
                            $coeff_c = $orelCoeff;
                        }else{
                            $coeff_c = $reshkaCoeff;
                        }

                        $setting = Setting::first();
                        $shoot_bank = $setting->shoot_bank;


                        if($sumBetCrazyCoinflip * ($coeff_c + 1) > $shoot_bank and $user->type_balance == 0){
                            $p = 1;
                            foreach ($coeffsCoin as $cc) {
                                if($sumBetCrazyCoinflip * ($cc + 1) < $shoot_bank){
                                    $orelCoeff = $cc;
                                    $coin2Coeffs[50] = $cc;
                                    $winType = 1;
                                    $p = 0;
                                    $coeff_c = $cc;
                                    break;
                                }
                            } 

                            if($p == 1){
                                $cc = 2;
                                $orelCoeff = $cc;
                                $coin2Coeffs[50] = $cc;
                                $winType = 1;
                                $p = 0;
                                $coeff_c = $cc;
                            }
                        }

                        $winUser = $sumBetCrazyCoinflip * ($coeff_c + 1);

                        $count_tourniers = Tourniers::where('game_id', 0)->where('status', 1)->count();
                        if($count_tourniers > 0 && $user->type_balance == 0){
                            $tournier = Tourniers::where('game_id', 0)->where('status', 1)->first();


                            $count_tournier_table = TournierTable::where('user_id', $user->id)->count();
                            if($count_tournier_table == 0){
                                TournierTable::create(array(
                                    'tournier_id' => $tournier->id,
                                    'user_id' => $user->id,
                                    'avatar' => $user->avatar,
                                    'name' => $user->name,
                                    'scores' => $winUser
                                ));
                            }else{
                                $tournier_table = TournierTable::where('user_id', $user->id)->first();
                                $tournier_table->scores += $winUser;
                                $tournier_table->save();

                            }

                        }

                        $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

                        $lastbalance = $userBalance;
                        $newbalance = $userBalance + $winUser;

                        $user->type_balance == 0 ? $user->balance += $winUser : $user->demo_balance += $winUser;

                        $user->save();

                        // $game->delete();

                        \Cache::put('shootGame.user.'. $user->id.'game', '');
                        \Cache::put('shootGame.user.'. $user->id.'start', 0);

                        $callback = array(
                            'icon_game' => 'hunt',
                            'name_game' => 'Shoot',
                            'avatar' => $user->avatar,
                            'name' => $user->name,
                            'bet' => round($sumBetsCrazy, 2),
                            'win' => $winUser
                        );

                        $this->redis->publish('history', json_encode($callback));

                        $bets = \Cache::get('games');
                        $bets = json_decode($bets);
                        $bets[] = $callback;
                        $bets = array_slice($bets, -10, 10);

                        $bets = json_encode($bets);

                        \Cache::put('games', $bets);

                        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

                        $hist_balance = array(
                            'user_id' => $user->id,
                            'type' => 'Выигрыш в Тире',
                            'balance_before' => $userBalance,
                            'balance_after' => $userBalance + $winUser,
                            'date' => date('d.m.Y H:i')
                        );

                        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

                        $cashe_hist_user = json_decode($cashe_hist_user);
                        $cashe_hist_user[] = $hist_balance;
                        $cashe_hist_user = json_encode($cashe_hist_user);
                        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

                        if($user->type_balance == 0){
                            $setting = Setting::first();

                            $setting->shoot_bank -= $winUser; 
                            $setting->save();   
                        }



                        return response(['success' => true, 'coin1Coeffs' => $coin1Coeffs, 'coin2Coeffs' => $coin2Coeffs,  'crazyCoeffs' => $crazyCoeffs, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'type' => 2, 'winUser' => $winUser, 'reshkaCoeff' => $reshkaCoeff, 'orelCoeff' => $orelCoeff, 'winType' => $winType]);
                    }

                    if($winNumber == 'bonusX3'){
                        $betsCrazy['1'] *= 3;
                        $betsCrazy['2'] *= 3;
                        $betsCrazy['5'] *= 3;
                        $betsCrazy['10'] *= 3;
                        $betsCrazy['coinflip'] *= 3;
                        $betsCrazy['pachinko'] *= 3;
                        $betsCrazy['cashhunt'] *= 3;
                        $betsCrazy['crazytime'] *= 3;

                        $sumBetsCrazy *= 3;

                        $game->bets = json_encode($betsCrazy);

                        \Cache::put('shootGame.user.'. $user->id.'game', json_encode($game));

                        // $game->save();

                        return response(['success' => true, 'crazyCoeffs' => $crazyCoeffs, 'type' => 0, 'newBets' => $betsCrazy, 'newSumBets' => $sumBetsCrazy, 'muliPlayer' => 1, 'multiCoeff' => 3]);
                    }

                    if($winNumber == 'bonusX5'){
                        $betsCrazy['1'] *= 5;
                        $betsCrazy['2'] *= 5;
                        $betsCrazy['5'] *= 5;
                        $betsCrazy['10'] *= 5;
                        $betsCrazy['coinflip'] *= 5;
                        $betsCrazy['pachinko'] *= 5;
                        $betsCrazy['cashhunt'] *= 5;
                        $betsCrazy['crazytime'] *= 5;

                        $sumBetsCrazy *= 5;

                        $game->bets = json_encode($betsCrazy);

                        \Cache::put('shootGame.user.'. $user->id.'game', json_encode($game));
                        // $game->save();

                        return response(['success' => true, 'crazyCoeffs' => $crazyCoeffs, 'type' => 0, 'newBets' => $betsCrazy, 'newSumBets' => $sumBetsCrazy, 'muliPlayer' => 1, 'multiCoeff' => 5]);
                    }

                }else{
                    if($winNumber == 1){
                        $winUser = $sumBetCrazyX1 * 2;
                    }

                    if($winNumber == 2){
                        $winUser = $sumBetCrazyX2 * 3;
                    }

                    if($winNumber == 5){
                        $winUser = $sumBetCrazyX5 * 6;
                    }

                    if($winNumber == 10){
                        $winUser = $sumBetCrazyX10 * 11;
                    }

                }

                $userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

                $lastbalance = $userBalance;
                $newbalance = $userBalance + $winUser;

                $user->type_balance == 0 ? $user->balance += $winUser : $user->demo_balance += $winUser;

                $user->save();

                if($winUser > 0){

                    $count_tourniers = Tourniers::where('game_id', 0)->where('status', 1)->count();
                    if($count_tourniers > 0 && $user->type_balance == 0){
                        $tournier = Tourniers::where('game_id', 0)->where('status', 1)->first();


                        $count_tournier_table = TournierTable::where('user_id', $user->id)->count();
                        if($count_tournier_table == 0){
                            TournierTable::create(array(
                                'tournier_id' => $tournier->id,
                                'user_id' => $user->id,
                                'avatar' => $user->avatar,
                                'name' => $user->name,
                                'scores' => $winUser
                            ));
                        }else{
                            $tournier_table = TournierTable::where('user_id', $user->id)->first();
                            $tournier_table->scores += $winUser;
                            $tournier_table->save();
                            
                        }

                    }


                    if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

                    $hist_balance = array(
                        'user_id' => $user->id,
                        'type' => 'Выигрыш в Тире',
                        'balance_before' => $userBalance,
                        'balance_after' => $userBalance + $winUser,
                        'date' => date('d.m.Y H:i')
                    );

                    $callback = array(
                        'icon_game' => 'hunt',
                        'name_game' => 'Shoot',
                        'avatar' => $user->avatar,
                        'name' => $user->name,
                        'bet' => round($sumBetsCrazy, 2),
                        'win' => $winUser
                    );

                    $this->redis->publish('history', json_encode($callback));

                    $bets = \Cache::get('games');
                    $bets = json_decode($bets);
                    $bets[] = $callback;
                    $bets = array_slice($bets, -10, 10);

                    $bets = json_encode($bets);

                    \Cache::put('games', $bets);

                    $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

                    $cashe_hist_user = json_decode($cashe_hist_user);
                    $cashe_hist_user[] = $hist_balance;
                    $cashe_hist_user = json_encode($cashe_hist_user);
                    \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

                    if($user->type_balance == 0){
                        $setting = Setting::first();

                        $setting->shoot_bank -= $winUser; 
                        $setting->save();   
                    }

                    $win = 1;
                }else{
                    $win = 0;

                    $callback = array(
                        'icon_game' => 'hunt',
                        'name_game' => 'Shoot',
                        'avatar' => $user->avatar,
                        'name' => $user->name,
                        'bet' => round($sumBetsCrazy, 2),
                        'win' => 0
                    );

                    $this->redis->publish('history', json_encode($callback));

                    $bets = \Cache::get('games');
                    $bets = json_decode($bets);
                    $bets[] = $callback;
                    $bets = array_slice($bets, -10, 10);

                    $bets = json_encode($bets);

                    \Cache::put('games', $bets);
                    
                }



                // $game->delete();

                \Cache::put('shootGame.user.'. $user->id.'game', '');
                \Cache::put('shootGame.user.'. $user->id.'start', 0);

                return response(['success' => true, 'crazyCoeffs' => $crazyCoeffs, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'type' => $win, 'winUser' => $winUser]);

            }
        }




// public function all(){
//     return Cache::remember('gallerys', $minutes='60', function(){
//         return Gallery::all();
//     });
// }

// public function find($id){
//     return Cache::remember("gallerys.{$id}", $minutes='60', function() use($id){
//         if(Cache::has('gallerys')) return Cache::has('gallerys')->find($id);
//             return Gallery::find($id);
//     });
// }



// $value = Cache::remember('users', $minutes, function () {
//   return DB::table('users')->get();
// });