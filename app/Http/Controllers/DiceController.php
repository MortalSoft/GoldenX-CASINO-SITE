<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\HistoryBalance;
use App\Setting;
use Illuminate\Support\Facades\Redis;

class DiceController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redis = Redis::connection();
	}

	public function generate_string($input, $strength = 16) {
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $strength; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}

		return $random_string;
	}

	public function play(Request $r){
		//return response(['error' => 'Произошла неизвестная ошибка. Обновите страницу']);

		$bet = $r->bet;
		$percent = $r->percent;
		$type = $r->type;
		$setting = Setting::first();

		$bank_game = \Cache::get('diceGame.bank') ?? 200;
        $profit_game = \Cache::get('diceGame.profit') ?? 0;


		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		if($bet < 1){
			return response(['success' => false, 'mess' => 'Сумма ставки меньше 1' ]);
		}
		if($user->ban == 1){
			return response(['error' => 'Произошла неизвестная ошибка']);
		}
		if(!is_numeric($bet)){
			return response(['success' => false, 'mess' => 'Введите сумму ставки корректно' ]);
		}

		if(!is_numeric($percent)){
			return response(['success' => false, 'mess' => 'Введите процент корректно' ]);
		}

		if($percent < 1){
			return response(['success' => false, 'mess' => 'Процент меньше 1' ]);
		}

		if($percent > 95){
			return response(['success' => false, 'mess' => 'Процент больше 95' ]);
		}

		$userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

		if($userBalance < $bet){
			return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
		}

		$numb = rand(0, 9999) / 100;
		$numb = round($numb, 2);
		$percent = round($percent, 2);

		$lastbalance = $userBalance;

		$coef = round(100 / $percent, 2);
		$win = round($bet * $coef, 2);

		$win_d = 0;
		if($type == 'minPlay' and $numb <= $percent){ $win_d = 1;}
		if($type == 'maxPlay' and $numb >= (100 - $percent)){ $win_d = 1;}

		$youtube = 1;
		
		if($user->type_balance == 1){
			$youtube = 3;
		}
		if($win_d == 1){
			if($youtube != 3){
				if($bank_game < ($win - $bet)){
					if($type == 'minPlay'){ $numb = rand($percent * 100 + 1, 9999) / 100; }
					if($type == 'maxPlay'){ $numb = rand(0, $percent * 100 - 1) / 100; }
					$win_d = 0;
				}
			}
			
		}

		$numb = round($numb, 2);


		if($type == 'minPlay' and $numb <= $percent){ $win_d = 1;}
		if($type == 'maxPlay' and $numb >= (100 - $percent)){ $win_d = 1;}
		
		// \Cache::put('user.'.$user->id.'.historyBalance', '[]');
		if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }


		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$';
		$salt1 = $this->generate_string($permitted_chars, 5);
		$salt2 = $this->generate_string($permitted_chars, 5);
		$full_string = $salt1.':'.$numb.':'.$salt2;
		$hash = hash('md5', $full_string);


		
		$hist_balance =	array(
			'user_id' => $user->id,
			'type' => 'Ставка в Dice',
			'balance_before' => $userBalance,
			'balance_after' => $userBalance - $bet,
			'date' => date('d.m.Y H:i')
		);

		$cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

		$cashe_hist_user = json_decode($cashe_hist_user);
		$cashe_hist_user[] = $hist_balance;
		$cashe_hist_user = json_encode($cashe_hist_user);
		\Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

		$user->sum_bet += $bet;
		if($win_d == 1){
			// WIN
			
			$newbalance = $userBalance + ($win - $bet);

			$user->win_games += 1;
			$user->sum_win += $win;
			if($user->max_win < $win ){
				$user->max_win = $win;
			}

			$sumW = $win - $bet;
			$user->sum_to_withdraw -= $sumW;
			// $user->balance += ($win - $bet);
			$user->type_balance == 0 ? $user->balance += ($win - $bet) : $user->demo_balance += ($win - $bet);
			$user->save();

			if($youtube != 3){
				\Cache::put('diceGame.bank', $bank_game - ($win - $bet));
				$setting->dice_bank -= ($win - $bet);
				$setting->save();
			}

			
			$hist_balance = array(
				'user_id' => $user->id,
				'type' => 'Выигрыш в Dice',
				'balance_before' => $userBalance - $bet,
				'balance_after' => $newbalance,
				'date' => date('d.m.Y H:i')
			);


			$cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

			$cashe_hist_user = json_decode($cashe_hist_user);
			$cashe_hist_user[] = $hist_balance;
			$cashe_hist_user = json_encode($cashe_hist_user);
			
			\Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

			$callback = array(
				'icon_game' => 'dice',
				'name_game' => 'Dice',
				'avatar' => $user->avatar,
				'name' => $user->name,
				'bet' => round($bet, 2),
				'win' => round($win, 2)
			);

			$this->redis->publish('history', json_encode($callback));
			
			$bets = \Cache::get('games');
			$bets = json_decode($bets);
			$bets[] = $callback;
			$bets = array_slice($bets, -10, 10);

			$bets = json_encode($bets);

			\Cache::put('games', $bets);

			return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'type' => 'win', 'number' => "$numb", 'salt1' => $salt1, 'full_string' => $full_string, 'salt2' => $salt2, 'hash' =>  $hash, 'win' => $win]);
		}else{
			// LOSE

			$newbalance = $userBalance - $bet;
			$user->lose_games += 1;
			$user->sum_to_withdraw -= $bet;
			$user->type_balance == 0 ? $user->balance -= $bet : $user->demo_balance -= $bet;
			// $user->balance -= $bet;
			$user->save();

			if($youtube != 3){
				\Cache::put('diceGame.bank', $bank_game + (round($bet, 2) * 0.8));
        		\Cache::put('diceGame.profit', $profit_game + (round($bet, 2) * 0.2));
			}

			$callback = array(
				'icon_game' => 'dice',
				'name_game' => 'Dice',
				'avatar' => $user->avatar,
				'name' => $user->name,
				'bet' => round($bet, 2),
				'win' => 0
			);

			$this->redis->publish('history', json_encode($callback));

			$bets = \Cache::get('games');
			$bets = json_decode($bets);
			$bets[] = $callback;
			$bets = array_slice($bets, -10, 10);

			$bets = json_encode($bets);

			\Cache::put('games', $bets);

			return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance, 'type' => 'lose', 'number' => "$numb", 'salt1' => $salt1, 'full_string' => $full_string, 'salt2' => $salt2, 'hash' =>  $hash, 'win' => 0]);
		}
	}
}
