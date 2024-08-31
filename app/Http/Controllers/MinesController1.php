<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Promo;
use App\User;
use App\Setting;
use App\MinesGame;
use Illuminate\Support\Facades\Redis;

class MinesController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redis = Redis::connection();
	}

	function getCoeff($count, $steps) {
		$coeff = 1;
		for ($i = 0; $i < (25 - $count) && $steps > $i; $i++) {
			$coeff *= ((25 - $i) / (25 - $count - $i));
		}
		return $coeff;
	}

	public function autoClick(){
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		// $game = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->first();

		// $games_on = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->count();

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
		$select = mt_rand(1,25);

		if(in_array($select,$click)){
			$i = 0;
			while(in_array($select,$click)){
				$i += 1;
				$select = mt_rand(1,25);
				if($i > 25){ 
					return response(['success' => false, 'mess' => 'Ошибка' ]);               
					break;
				}
			}
		}

		return response(['success' => true, 'num' => $select ]);

	}
	

	public function click(Request $r){
		$setting = Setting::first();
		$mine = round($r->mine);
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		if($mine < 1 or $mine > 25){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}

		// $game = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->first();

		// $games_on = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->count();


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
		$bet = $cache_gameMine->bet;
		$num_mines = $cache_gameMine->num_mines;
		$step = $cache_gameMine->step;
		$bombs = json_decode($cache_gameMine->mines);

		if(in_array($mine, $click)){
			return response(['success' => false, 'mess' => 'Вы уже нажимали на эту ячейку' ]);
		}

		$youtube = $user->admin;
		$auto_mines = $setting->auto_mines;
		if($auto_mines == 0){
			$youtube = 3;
		}


		if(in_array($mine, $bombs)){
  			// LOSE

			\Cache::put('minesGame.user.'. $user->id.'game', '');
			\Cache::put('minesGame.user.'. $user->id.'start', 0);

			// $game_publish = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step', 'mines', 'hash', 'pole_hash', 'salt1', 'salt2', 'full_string')->first();

			// $game->delete();

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



			$callback = array(
				'icon_game' => 'mine',
				'name_game' => 'Mines',
				'avatar' => $user->avatar,
				'name' => $user->name,
				'bet' => round($cache_gameMine->bet, 2),
				'win' => 0
			);

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
			$nexCoeff = self::getCoeff($num_mines, $step + 1);

			$cache_gameMine->win = ($cache_gameMine->bet * $nexCoeff);
			$cache_gameMine->click = json_encode($click);
			$cache_gameMine->step = $cache_gameMine->step + 1;
			\Cache::put('minesGame.user.'. $user->id.'game', json_encode($cache_gameMine));


			// $game->win = ($game->bet * $nexCoeff);
			// $game->click = json_encode($click);
			// $game->step += 1;
			// $game->save();

			$win_money = ($bet * self::getCoeff($num_mines, $step + 2)) - $bet;

			if($youtube != 3){

				if($dice_bank < ($bet * self::getCoeff($num_mines, $step + 2)) or $dice_bank < 200){
					// Проигрыш 
					$bombs[0] = $mine; 

					$hash_m = [];
					for ($i=0; $i < 25; $i++) { 
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

					// $game->salt1 = $salt1;
					// $game->salt2 = $salt2;
					// $game->full_string = $full_string;
					// $game->hash = $hash;
					// $game->mines = json_encode($bombs);
					// $game->save();

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



					// $game_publish = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step', 'mines', 'hash', 'pole_hash', 'salt1', 'salt2', 'full_string')->first();

					// $game->delete();

					\Cache::put('minesGame.user.'. $user->id.'game', '');
					\Cache::put('minesGame.user.'. $user->id.'start', 0);


					$callback = array(
						'icon_game' => 'mine',
						'name_game' => 'Mines',
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

					return response(['success' => true, 'type' => 'lose', 'game' => $game]);

				}
			}
			// $game = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step')->first();

			$game = [];
			$game['click'] = $cache_gameMine->click;
			$game['win'] = $cache_gameMine->win;
			$game['bet'] = $cache_gameMine->bet;
			$game['num_mines'] = $cache_gameMine->num_mines;
			$game['step'] = $cache_gameMine->step;


			$gameOff = 0;
			if(25 - $num_mines - $step - 1 == 0){
				$gameOff = 1;
			}
			return response(['success' => true, 'type' => 'next', 'game' => $game, 'gameOff' => $gameOff ]);

		}

	}

	public function get(){
		if(\Auth::guest()){return response(['success' => false]);}

		$user = \Auth::user();

		// $games_on = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->count();
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

		// $game = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step')->first();
		return response(['success' => true, 'game' => $game]);
	}

	public function finish(){
		$setting = Setting::first();

		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		// $game = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->first();

		// $games_on = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->count();

		$games_on = 0;
		if(\Cache::has('minesGame.user.'. $user->id.'start')){
			$games_on = \Cache::get('minesGame.user.'. $user->id.'start');
		}

		if($games_on == 0){
			return response(['success' => false, 'mess' => 'Ошибка' ]);
		}


		$cache_gameMine = \Cache::get('minesGame.user.'. $user->id.'game');
		$cache_gameMine = json_decode($cache_gameMine);


		$step = $cache_gameMine->step;
		if($step < 1){
			return response(['success' => false, 'mess' => 'Вы не нажали ни на одну клетку' ]);
		}

		$win = $cache_gameMine->win;
		$bet = $cache_gameMine->bet;

		// $game_publish = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step', 'mines', 'hash', 'pole_hash', 'salt1', 'salt2', 'full_string')->first();

		// $game->delete();

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



					// $game_publish = MinesGame::where(['user_id' => $user->id, 'onOff' => 1])->select('click', 'win', 'bet', 'num_mines', 'step', 'mines', 'hash', 'pole_hash', 'salt1', 'salt2', 'full_string')->first();

					// $game->delete();

		\Cache::put('minesGame.user.'. $user->id.'game', '');
		\Cache::put('minesGame.user.'. $user->id.'start', 0);



		$youtube = $user->admin;
		$auto_mines = $setting->auto_mines;
		if($auto_mines == 0){
			$youtube = 3;
		}


		$win_money = $win;

		if($youtube != 3){
			$setting->dice_bank -= $win_money;
			$setting->save(); 
		}

		if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

		$hist_balance =	array(
			'user_id' => $user->id,
			'type' => 'Выигрыш в Mines',
			'balance_before' => $user->balance,
			'balance_after' => $user->balance + $win,
			'date' => date('d.m.Y H:i')
		);

		$cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

		$cashe_hist_user = json_decode($cashe_hist_user);
		$cashe_hist_user[] = $hist_balance;
		$cashe_hist_user = json_encode($cashe_hist_user);
		\Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

		$lastbalance = $user->balance;
		$newbalance = $user->balance + $win;
		$user->balance += $win;
		$user->save();

		$callback = array(
			'icon_game' => 'mine',
			'name_game' => 'Mines',
			'avatar' => $user->avatar,
			'name' => $user->name,
			'bet' => round($cache_gameMine->bet, 2),
			'win' => round($win, 2)
		);

		$this->redis->publish('history', json_encode($callback));

		$bets = \Cache::get('games');
		$bets = json_decode($bets);
		$bets[] = $callback;
		$bets = array_slice($bets, -10, 10);

		$bets = json_encode($bets);

		\Cache::put('games', $bets);

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
		$setting = Setting::first();

		$bet = $r->bet;
		$bomb = $r->bomb;
		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();

		if(\Cache::has('action.user.' . $user->id)){ return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);}
		\Cache::put('action.user.' . $user->id, '', 0.8);

		if($bet < 1){
			return response(['success' => false, 'mess' => 'Сумма ставки меньше 1' ]);
		}
		if($bomb < 2 or $bomb > 24){
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

		if($user->balance < $bet){
			return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
		}

		

		$resultmines = range(1,25);
		shuffle($resultmines);
		$resultmines = array_slice($resultmines,0,$bomb);
		// $resultmines = [1];
		$hash_m = [];
		for ($i=0; $i < 25; $i++) { 
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

		\Cache::put('minesGame.user.'. $user->id.'start', 1);

		$cache_gameMine = array(
			'user_id'  => \Auth::user()->id,
			'bet' => $bet,
			'num_mines' => $bomb,
			'onOff' => 1,
			'step' => 0,
			'win' => 0,
			'mines' => $resultmines,
			'click' => '[]',
			'hash' => $hash,
			'pole_hash' => $hash_m,
			'salt1' => $salt1,
			'salt2' => $salt2,
			'full_string' => $full_string
		);

		\Cache::put('minesGame.user.'. $user->id.'game', json_encode($cache_gameMine));

		if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }


		$hist_balance =	array(
			'user_id' => $user->id,
			'type' => 'Ставка в Mines',
			'balance_before' => $user->balance,
			'balance_after' => $user->balance - $bet,
			'date' => date('d.m.Y H:i')
		);

		$cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

		$cashe_hist_user = json_decode($cashe_hist_user);
		$cashe_hist_user[] = $hist_balance;
		$cashe_hist_user = json_encode($cashe_hist_user);
		\Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


		$lastbalance = $user->balance;
		$user->balance -= $bet;
		$user->save();


		$youtube = $user->admin;
		$auto_mines = $setting->auto_mines;
		if($auto_mines == 0){
			$youtube = 3;
		}


		if($youtube != 3){
			$setting->dice_bank += ($bet * 0.9);
			$setting->dice_profit += ($bet * 0.1);
			$setting->save();	
		}

		
		
		

		$newbalance = $user->balance - $bet;


		return response(['success' => true, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);

	}
}
