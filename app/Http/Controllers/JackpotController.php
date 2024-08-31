<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Jackpot;
use Auth;
use App\User;
use App\RandomKey;
use Redis;
use App\JackpotHistory;
class JackpotController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redis = Redis::connection();
	}

	function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	function random_color() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}


	public function get()
	{        
		$maxWin = JackpotHistory::max('win') ?? 0;
		$gamesToday = JackpotHistory::whereDate('created_at', \Carbon\Carbon::today())->count();

		$jackpot = Jackpot::all();
		$sumBetUser = 0;
		if(\Auth::user()){
			$user = \Auth::user();
			$sumBetUser = Jackpot::where('user_id',$user->id)->sum('bet');
		}
		
		return response(['success' => 'success','jackpot' => $jackpot, 'players'=>collect($jackpot)->unique('user_id')->sortBy('chance')->values(), 'gamesToday' => $gamesToday, 'maxWin' => $maxWin, 'sumBetUser' => $sumBetUser ]);
	}

	public function all()
	{        
		
		$jackpot = JackpotHistory::orderBy('id', 'desc')->limit(10)->get();
		
		
		return response(['success' => 'success','jackpot' => $jackpot ]);
	}

	public function getKey()
    {
        $MAX_RANDOM_KEY_ID = 10;
        $MIN_RANDOM_KEY_ID = 1;

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

    public function randNumber($min, $max)
    {
        $key = self::getKey();

        $proxy_ip = '91.198.208.72:8000'; //IP адрес сервера прокси и порт
        $loginpassw = 'D28xH1:FvysGs'; //логин и пароль для прокси
        $timeout = 5;

        $p = array(
            'apiKey' => "$key",
            'n' => 1,
            'min' => $min,
            'max' => $max,
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
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        // curl_setopt($ch, CURLOPT_PROXY, $proxy_ip);
        // curl_setopt($ch, CURLOPT_PROXYUSERPWD, $loginpassw);
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

	public function generateJackpotNumber(){
		$max = Jackpot::max('tick_two');
		$result = self::randNumber(1, $max);
        $rand = $result['result']['random']['data']['0'];
        $random = json_encode($result['result']['random']);
        $signature = $result['result']['signature'];
        $setting = Setting::first();
        $setting->jackpot_rand = $rand;
        $setting->jackpot_random = $random;
        $setting->jackpot_signature = $signature;
        $setting->save();
        return 'True';
	}

	public function chance(){
		$jackpots = Jackpot::all();
		$jackpots = collect($jackpots)->unique('user_id')->all();

		if(count($jackpots) > 1){
			$sumBetsRound = Jackpot::sum('bet');
			foreach($jackpots as $jackpot){
				$sumBets = Jackpot::where('user_id',$jackpot->user_id)->sum('bet');
				// $sumBets = $jackpot->bet;
				
				$chance = 100/($sumBetsRound/$sumBets);
				Jackpot::where('user_id',$jackpot->user_id)->update(['chance'=>$chance]);
			}
		}
		$this->redis->publish('jackpotUpdateChance', json_encode(collect(Jackpot::all())->unique('user_id')->sortBy('chance')->values()));
	}

	public function cashHuntFinish(){
		$setting = Setting::first();
		$coefsHunt = $setting->coefsHunt;
		$coefsHunt = json_decode($coefsHunt);

		$jackpot = collect(Jackpot::all())->unique('user_id')->values();
		foreach ($jackpot as $j) {
			$bet = $j->bet;
			$cashHuntNumber = $j->cashHuntNumber;
			$cashHuntNumberCoefd = $coefsHunt[$cashHuntNumber - 1];
			$cashHuntSelected = $j->cashHuntSelected;
			$user_id = $j->user_id;
			$id = $j->id;
			$newBet = $bet * $cashHuntNumberCoefd;

			$jack = Jackpot::where('user_id', $user_id)->get();
			foreach ($jack as $uj) {
				$id_j = $uj->id;
				$jack_u = Jackpot::where('id', $id_j)->first();
				$bet = $jack_u->bet;
				$jack_u->bet = $bet * $cashHuntNumberCoefd;
				$jack_u->cashHuntSelected = $bet * $cashHuntNumberCoefd;
				$jack_u->cashHuntCoeff = $cashHuntNumberCoefd;
				$jack_u->save();
			}
			

			$sumBetJackpot = Jackpot::where('user_id', $user_id)->sum('bet');

			
		}

		$info = collect(Jackpot::all())->unique('user_id')->values();
		$this->redis->publish('jackpotUpdateBet', json_encode(array('info' => $info, 'jackpot' => Jackpot::all())));
		$this->chance();
	}

	public function selectHunt(Request $request){
		$setting = Setting::first();
		$coefsHunt = $setting->coefsHunt;
		$coefsHunt = json_decode($coefsHunt);


		$id = round($request->id);

		if (Auth::guest()) { return response(['error'=>'Авторизуйтесь!']); }
		$user = Auth::user();
		if(Setting::first()->status_jackpot != 2) return response(['error'=>'Бонусная игра не началась или закончилась!']);
		$count = Jackpot::where('user_id', $user->id)->count();
		if($count == 0){
			return response(['error'=>'Вы не учавствуете в этой игре']); 
		}
		if($id < 1 or $id > 64){
			return response(['error'=>'Ошибка']); 
		}

		$sumBet = Jackpot::where('user_id', $user->id)->sum('bet');
		$jackpotUser = Jackpot::where('user_id', $user->id)->first();

		if($user->admin != 3){
			if($jackpotUser->cashHuntSelected != 0){
				$setting->jackpot_bank += $sumBet * $coefsHunt[$jackpotUser->cashHuntNumber - 1];
				$setting->save();
				$setting = Setting::first();
			}		


			$coeffHunt = $coefsHunt[$id - 1];

		
			$jackpot_bank = $setting->jackpot_bank;
			if($sumBet * $coeffHunt > $jackpot_bank){
				$coeffHuntMay = round($jackpot_bank / $sumBet);
				if($coeffHuntMay > 10){
					$coeffHuntMay = 10;
				}
				if($coeffHuntMay < 1){
					$coeffHuntMay = 0;
				}
				$coeffHuntR = rand(0, $coeffHuntMay);
				if($coeffHuntR == 0){
					$coeffHunt = 0.5;
				}else{
					$coeffHunt = $coeffHuntR;
				}

				$coefsHunt[$id - 1] = $coeffHunt;
			}

			$setting->jackpot_bank -= $sumBet * $coeffHunt;
			$setting->coefsHunt = json_encode($coefsHunt);
			$setting->save();
		}
		


		Jackpot::where('user_id', $user->id)->update(['cashHuntNumber' => $id, 'cashHuntSelected' => 1]);


		return response(['success' => true ]);
	}
	public function bet(Request $request){
		$bet = $request->bet;
		// return response(['error' => 'Произошла неизвестная ошибка']);

		if (Auth::guest()) { return response(['error'=>'Авторизуйтесь!']); }
		$user = Auth::user();

if($user->ban == 1){
return response(['error' => 'Произошла неизвестная ошибка']);
}
		if(Setting::first()->status_jackpot) return response(['error'=>'Игра началась или закончилась!']);
		if(Jackpot::where(['user_id'=>$user->id])->count() >= 3) return response(['error'=>'Максимум 3 ставки в раунде']);
		if($bet < 1) return response(['error'=>'Минимальная ставка 1 монета']);
		if($bet > 10000) return response(['error'=>'Максимальная ставка 10000 монет']);
		if($bet > $user->balance) return response(['error'=>'Недостаточно средств']);
		if($user->deps < 99) return response(['error' => 'Для того чтобы сделать ставку вы должны иметь минимальную сумму пополнений - 99р ']);
		$jackpot = Jackpot::all();
		if(!$jackpot->count()){
			$tickets = [1,round($bet * 10)];
		}else{
			$tickets = [collect($jackpot)->last()->tick_two+1,round(collect($jackpot)->last()->tick_two + (10 * $bet))];
		}
		if (Jackpot::where(['user_id'=>$user->id])->count() > 0){
			$color = Jackpot::where(['user_id'=>$user->id])->first()->color;
		}else{
			$color = $this->random_color();
		}
		Jackpot::create([
			'user_id'=>$user->id,
			'color'=>$color,
			'login'=>$user->name,
			'img'=>$user->avatar,
			'bet'=>$bet,
			'tick_one'=>$tickets[0],
			'tick_two'=>$tickets[1],
			'chance'=>100
		]);

		$this->chance();
		$user->balance -= $bet;
		$user->save();

		$jackpot = Jackpot::where('user_id',$user->id)->first();
		$callback = [
			'date' => [
				'user_id'=>$user->id,
				'color'=>$color,
				'img'=>$user->avatar,
				'login'=>$user->name,
				'bet'=>$bet,
				'tickets'=>$tickets,
				'chance'=>$jackpot->chance,
			],
		];
		$this->redis->publish('jackpotBet', json_encode($callback));

		$setting = Setting::first();
		$setting->jackpot_bank += ($bet * 0.9);
		$setting->save();
		return response(
			[
				'sumBetUser' => Jackpot::where('user_id',$user->id)->sum('bet'),
				'success'=>'Ставка принята',
				'newbalance'=>$user->balance,
				'lastbalance' => $user->balance + $bet
			]
		);
	}
}
