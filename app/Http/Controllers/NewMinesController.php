<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Promo;
use App\User;
use App\Setting;
use App\MinesGame;
use Illuminate\Support\Facades\Redis;
use App\Tourniers;
use App\TournierTable;

class NewMinesController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redis = Redis::connection();
	}

	function getCoeff($count, $steps, $level) {
		$coeff = 1;
		for ($i = 0; $i < ($level - $count) && $steps > $i; $i++) {
			$coeff *= (($level - $i) / ($level - $count - $i));
		}
		return $coeff;
	}

	public function autoClick(){
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}
		if($games_on == 0){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}

		$cache_gameMine = \Cache::get('minesGame.user.'. $user->id.'game');
		$game = json_decode($cache_gameMine);

		$click = json_decode($game->click);
		$level = $game->level;
		$select = mt_rand(1,$level);

		if(in_array($select,$click)){
			$i = 0;
			while(in_array($select,$click)){
				$i += 1;
				$select = mt_rand(1,$level);
				if($i > 25){ 
					return response(['success' => false, 'mess' => 'Ошибка' ]);               
					break;
				}
			}
		}

		return response(['success' => true, 'num' => $select ]);

	}
	

	public function click(Request $r){
		$bank_game = \Cache::get('minesGame.bank') ?? 200;
        $profit_game = \Cache::get('minesGame.profit') ?? 0;

		$setting = Setting::first();
		$mine = round($r->mine);
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}


		if($games_on == 0){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}

		$cache_gameMine = \Cache::get('minesGame.user.'. $user->id.'game');
		$cache_gameMine = json_decode($cache_gameMine);


		$click = json_decode($cache_gameMine->click);
		$win = $cache_gameMine->win;
		$level = $cache_gameMine->level;

		if($mine < 1 or $mine > $level){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}

		$bet = $cache_gameMine->bet;
		$num_mines = $cache_gameMine->num_mines;
		$step = $cache_gameMine->step;
		$bombs = json_decode($cache_gameMine->mines);

		if(in_array($mine, $click)){
			return response(['success' => false, 'mess' => 'Вы уже нажимали на эту ячейку' ]);
		}

		$youtube = 1;
		if($user->type_balance == 1){
			$youtube = 3;
		}
		


		if(in_array($mine, $bombs)){
  			// LOSE

			

			\Cache::put('minesGame.user.'. $user->id.'game', '');
			\Cache::put('minesGame.user.'. $user->id.'start', 0);

			$game = [];
			$game['click'] = $cache_gameMine->click;
			$game['win'] = $cache_gameMine->win;
			$game['bet'] = $cache_gameMine->bet;
			$game['num_mines'] = $cache_gameMine->num_mines;
			$game['step'] = $cache_gameMine->step;
			$game['mines'] = $cache_gameMine->mines;
			$game['hash'] = $cache_gameMine->hash;
			$game['pole_hash'] = $cache_gameMine->pole_hash;
			$game['salt1'] = $cache_gameMine->salt1;
			$game['salt2'] = $cache_gameMine->salt2;
			$game['bonusMine'] = $cache_gameMine->bonusMine;
			$game['full_string'] = $cache_gameMine->full_string;

			$callback = array(
				'icon_game' => 'mines',
				'name_game' => 'Mines',
				'avatar' => $user->avatar,
				'name' => $user->name,
				'bet' => round($cache_gameMine->bet, 2),
				'win' => 0
			);

			$user->sum_bet += $cache_gameMine->bet;
			$user->lose_games += 1;
			$user->count_win = 0;
			$user->sum_to_withdraw -= $cache_gameMine->bet;
			$user->save();

			$this->redis->publish('history', json_encode($callback));
			
			$bets = \Cache::get('games');
			$bets = json_decode($bets);
			$bets[] = $callback;
			$bets = array_slice($bets, -10, 10);

			$bets = json_encode($bets);

			\Cache::put('games', $bets);


			return response(['success' => true, 'type' => 'lose', 'game' => $game ]);
		}else{
  			// NEXT
			$dice_bank = $setting->dice_bank;

			$click[] = $mine;
			$nexCoeff = self::getCoeff($num_mines, $step + 1, $level);


			$cache_gameMine->win = ($cache_gameMine->bet * $nexCoeff);
			$cache_gameMine->click = json_encode($click);
			$cache_gameMine->step = $cache_gameMine->step + 1;
			\Cache::put('minesGame.user.'. $user->id.'game', json_encode($cache_gameMine));

			$win_money = ($bet * self::getCoeff($num_mines, $step + 1, $level));

			if($youtube != 3){

				if($win_money > $bank_game){
					// Проигрыш 
					$bombs[0] = $mine; 

					$hash_m = [];
					for ($i=0; $i < $level; $i++) { 
						$hash_m[] = 0;
					}

					foreach ($bombs as $id => $m) {
						$hash_m[$m - 1] = 1;
					}
					$hash_m = implode("|", $hash_m);

					$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$';
					$salt1 = $this->generate_string($permitted_chars, 5);
					$salt2 = $this->generate_string($permitted_chars, 5);
					$full_string = $salt1.':'.$hash_m.':'.$salt2;
					$hash = hash('md5', $full_string);


					\Cache::put('minesGame.user.'. $user->id.'game', '');
					\Cache::put('minesGame.user.'. $user->id.'start', 0);

					$game = [];
					$game['click'] = $cache_gameMine->click;
					$game['win'] = $cache_gameMine->win;
					$game['bet'] = $cache_gameMine->bet;
					$game['num_mines'] = $cache_gameMine->num_mines;
					$game['step'] = $cache_gameMine->step;
					$game['mines'] = json_encode($bombs);
					$game['hash'] = $hash;
					$game['pole_hash'] = $cache_gameMine->pole_hash;
					$game['salt1'] = $salt1;
					$game['salt2'] = $salt2;
					$game['full_string'] = $full_string;
					$game['bonusMine'] = $cache_gameMine->bonusMine;


					$callback = array(
						'icon_game' => 'mines',
						'name_game' => 'Mines',
						'avatar' => $user->avatar,
						'name' => $user->name,
						'bet' => round($bet, 2),
						'win' => 0
					);

					$user->sum_bet += $cache_gameMine->bet;
					$user->lose_games += 1;
					$user->count_win = 0;
					$user->save();


					$this->redis->publish('history', json_encode($callback));

					$bets = \Cache::get('games');
					$bets = json_decode($bets);
					$bets[] = $callback;
					$bets = array_slice($bets, -10, 10);

					$bets = json_encode($bets);

					\Cache::put('games', $bets);

					return response(['success' => true, 'type' => 'lose', 'game' => $game ]);

				}
			}
			
			$game = [];
			$game['click'] = $cache_gameMine->click;
			$game['win'] = $cache_gameMine->win;
			$game['bet'] = $cache_gameMine->bet;
			$game['num_mines'] = $cache_gameMine->num_mines;
			$game['step'] = $cache_gameMine->step;

			$gameOff = 0;
			if($level - $num_mines - $step - 1 == 0){
				$gameOff = 1;
			}
			return response(['success' => true, 'type' => 'next', 'game' => $game, 'gameOff' => $gameOff ]);

		}

	}

	public function get(){
		if(\Auth::guest()){return response(['success' => false]);}

		$user = \Auth::user();

		

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}

		if($games_on == 0){
			return response(['success' => false]);
		}

		

		$cache_gameMine = \Cache::get('minesGame.user.'. $user->id.'game');
		$cache_gameMine = json_decode($cache_gameMine);

		$game = [];
		$game['click'] = $cache_gameMine->click;
		$game['win'] = $cache_gameMine->win;
		$game['bet'] = $cache_gameMine->bet;
		$game['num_mines'] = $cache_gameMine->num_mines;
		$game['step'] = $cache_gameMine->step;
		$game['level'] = $cache_gameMine->level;
		$game['bonusIkses'] = $cache_gameMine->bonusIkses;
		$game['bonusMine'] = $cache_gameMine->bonusMine;


		return response(['success' => true, 'game' => $game]);
	}

	public function finish(){
		$bank_game = \Cache::get('minesGame.bank') ?? 200;
        $profit_game = \Cache::get('minesGame.profit') ?? 0;

		$setting = Setting::first();

		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if (\Cache::has('action.user.' . $user->id)) return response(['error' => 'Подождите 1 сек.']);
		\Cache::put('action.user.' . $user->id, '', 1);

		

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}


		if($games_on == 0 or $user->minesStart == 0){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}



		$cache_gameMine = \Cache::get('minesGame.user.'. $user->id.'game');
		$cache_gameMine = json_decode($cache_gameMine);

		$step = $cache_gameMine->step;
		if($step < 1){
			return response(['success' => false, 'mess' => 'Вы не нажали ни на одну клетку' ]);
		}
		$user->minesStart = 0;
		$user->save();

		$win = $cache_gameMine->win;
		$bet = $cache_gameMine->bet;

		

		$game = [];
		$game['click'] = $cache_gameMine->click;
		$game['win'] = $cache_gameMine->win;
		$game['bet'] = $cache_gameMine->bet;
		$game['num_mines'] = $cache_gameMine->num_mines;
		$game['step'] = $cache_gameMine->step;
		$game['mines'] = $cache_gameMine->mines;
		$game['hash'] = $cache_gameMine->hash;
		$game['pole_hash'] = $cache_gameMine->pole_hash;
		$game['salt1'] = $cache_gameMine->salt1;
		$game['salt2'] = $cache_gameMine->salt2;
		$game['full_string'] = $cache_gameMine->full_string;
		$game['bonusMine'] = $cache_gameMine->bonusMine;

		\Cache::put('minesGame.user.'. $user->id.'game', '');
		\Cache::put('minesGame.user.'. $user->id.'start', 0);

		$youtube = 1;
		if($user->type_balance == 1){
			$youtube = 3;
		}
		


		$win_money = $win;

		if($youtube != 3){
			\Cache::put('minesGame.bank', $bank_game - round($win, 2));
		}

		if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

		$userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;


		$hist_balance =	array(
			'user_id' => $user->id,
			'type' => 'Выигрыш в Mines',
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

		$user->sum_bet += $bet;
		$user->win_games += 1;
		$user->sum_win += $win;
		$user->minesStart = 0;
		if($user->max_win < $win ){
			$user->max_win = $win;
		}

		$sumW = $win - $bet;
		$user->sum_to_withdraw -= $sumW;


		$user->save();

		$callback = array(
			'icon_game' => 'mines',
			'name_game' => 'Mines',
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


		$count_tourniers = Tourniers::where('game_id', 1)->where('status', 1)->count();
		if($count_tourniers > 0 && $user->type_balance == 0){
			$tournier = Tourniers::where('game_id', 1)->where('status', 1)->first();


			$count_tournier_table = TournierTable::where('user_id', $user->id)->where('tournier_id', $tournier->id)->count();
			if($count_tournier_table == 0){
				TournierTable::create(array(
					'tournier_id' => $tournier->id,
					'user_id' => $user->id,
					'avatar' => $user->avatar,
					'name' => $user->name,
					'scores' => $win
				));
			}else{
				$tournier_table = TournierTable::where('user_id', $user->id)->where('tournier_id', $tournier->id)->first();
				$tournier_table->scores += $win;
				$tournier_table->save();

			}

		}

		return response(['success' => true, 'game' => $game, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);


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

	public function start(Request $r){
		$bank_game = \Cache::get('minesGame.bank') ?? 200;
        $profit_game = \Cache::get('minesGame.profit') ?? 0;

		$setting = Setting::first();

		$bet = $r->bet;
		$bomb = ($r->bomb); 
		$level = $r->level;
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();




		if($user->ban == 1){
			return response(['success' => false, 'mess' => 'Произошла неизвестная ошибка']);
		}
		if (\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите 1 сек.']);
        

		if($bet < 1){
			return response(['success' => false, 'mess' => 'Сумма ставки меньше 1' ]);
		}
		$levels = [16, 25, 36, 49];

		if (!in_array($level, $levels))
		{
			return response(['success' => false, 'mess' => 'Ошибка']);
		}

		if(round($bomb) != $bomb ){
			return response(['success' => false, 'mess' => 'Введите корректное кол-во бомб' ]);
		}


		if($bomb < 2 or $bomb > $level - 1){
			return response(['success' => false, 'mess' => 'Введите корректное кол-во бомб' ]);
		}

		if(!is_numeric($bet)){
			return response(['success' => false, 'mess' => 'Введите сумму ставки корректно' ]);
		}
		if(!is_numeric($bomb)){
			return response(['success' => false, 'mess' => 'Введите корректное кол-во бомб' ]);
		}

		// $games_on = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->count();

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}

		if($games_on > 0){
			return response(['success' => false, 'mess' => 'У вас есть активные игры' ]);
		}


		$userBalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;

		if($userBalance < $bet){
			return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
		}

		


		

		$resultmines = range(1,$level);
		shuffle($resultmines);
		$resultmines = array_slice($resultmines,0,$bomb);

		$hash_m = [];
		for ($i=0; $i < $level; $i++) { 
			$hash_m[] = 0;
		}

		foreach ($resultmines as $id => $m) {
			$hash_m[$m - 1] = 1;
		}
		$hash_m = implode("|", $hash_m);

		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ$';
		$salt1 = $this->generate_string($permitted_chars, 5);
		$salt2 = $this->generate_string($permitted_chars, 5);
		$full_string = $salt1.':'.$hash_m.':'.$salt2;
		$hash = hash('md5', $full_string);

		$resultmines = json_encode($resultmines); 
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
			$bonus = $user->bonusMine;
			$user->bonusMine = 0;
		}


		$bonusMine = 1;

		if($bonus == 1){
			
			for ($i=0; $i < 60; $i++) { 
				$ikses[] = rand(2, 7);
			}

			$bonusMine = rand(2, 7);
			$ikses[43] = $bonusMine;
		}

		$sum_bet *= $bonusMine;

		\Cache::put('minesGame.user.'. $user->id.'start', 1);


		$cache_gameMine = array(
			'user_id'  => \Auth::user()->id,
			'bet' => $sum_bet,
			'num_mines' => $bomb,
			'onOff' => 1,
			'step' => 0,
			'win' => 0,
			'level' => $level,
			'mines' => $resultmines,
			'click' => '[]',
			'hash' => $hash,
			'pole_hash' => $hash_m,
			'salt1' => $salt1,
			'salt2' => $salt2,
			'full_string' => $full_string,
			'bonusMine' => $bonusMine,
			'bonusIkses' => json_encode($ikses)
		);

		\Cache::put('minesGame.user.'. $user->id.'game', json_encode($cache_gameMine));

		if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }


		$hist_balance =	array(
			'user_id' => $user->id,
			'type' => 'Ставка в Mines',
			'balance_before' => $userBalance,
			'balance_after' => $userBalance - $bet,
			'date' => date('d.m.Y H:i')
		);

		$cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

		$cashe_hist_user = json_decode($cashe_hist_user);
		$cashe_hist_user[] = $hist_balance;
		$cashe_hist_user = json_encode($cashe_hist_user);
		\Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

		$user->minesStart = 1;
		$lastbalance = $userBalance;

		$user->type_balance == 0 ? $user->balance -= $bet: $user->demo_balance -= $bet;

		// $user->balance -= $bet;
		$user->save();


		$youtube = 1;
		if($user->type_balance == 1){
			$youtube = 3;
		}
		
	


		if($youtube != 3){
			\Cache::put('minesGame.bank', $bank_game + (round($bet, 2) * 0.8));
        	\Cache::put('minesGame.profit', $profit_game + (round($bet, 2) * 0.2));
		}

		
		
		

		$newbalance = $user->type_balance == 0 ? $user->balance : $user->demo_balance;;


		return response(['success' => true,'bonusMine'=>$bonusMine, 'ikses' => $ikses, 'bonus' => $bonus, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);

	}
}
