<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SystemDep;
use App\DepPromo;
use App\User;
use App\ActivePromo;
use App\Setting;
use App\Status;
use App\Payment;
use Illuminate\Support\Facades\Redis;

class PaymentController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->redis = Redis::connection();
	}

	public function resultLinePay(Request $r){
		$setting = Setting::first();

		$linepay_id = $setting->linepay_id;
		$linepay_secret_2 = $setting->linepay_secret_2;

		$m_id = $linepay_id; //ID вашего мерчанта
		$m_secret_2 = $linepay_secret_2; //Секретное слово №2 вашего мерчанта

		$order_id = $r->order_id; // Уникальный идентификатор заказа в вашей системе
		$amount = $r->amount; // Сумма заказа
		$sign = $r->sign; // Подпись
		$pay_id = $r->pay_id; // Уникальный идентификатор заказа в нашей системе
		$us_key = $r->us_key; // Дополнительный параметр

		$_sign = md5($m_id.'|'.$m_secret_2.'|'.$amount.'|'.$order_id);

		//проверка IP адреса
		function getIP() {
		if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
		return $_SERVER['REMOTE_ADDR'];
		}
		if (getIP() != '45.142.122.86') {
		echo "ip is ".getIP();
		}

		if ( $sign != $_sign ){
		die("wrong sign");
		}

		$unique_id = $order_id;
		$amount = $amount;

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

	}
	public function resultPaypalych(){
		$setting = Setting::first();

		$paypaylych_id = $setting->paypaylych_id;
		$paypaylych_token = $setting->paypaylych_token;

		$OutSum = $_GET['OutSum'];
		$InvId = $_GET['InvId'];
		$SignatureValue = $_GET['SignatureValue'];

		$apiToken = $paypaylych_token;

		$sign = strtoupper(md5($OutSum . ":" . $InvId . ":" . $apiToken));

		if($sign != $SignatureValue){
			die();
		}


		$unique_id = $InvId;
		$amount = $OutSum;

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

	}

	public function resultFK(Request $r){
		$setting = Setting::first();

		$merchant_id = $setting->fk_id;
		$secret_word = $setting->fk_secret_2;

		$sign = md5($merchant_id.':'.$r->AMOUNT.':'.$secret_word.':'.$r->MERCHANT_ORDER_ID);

		if ($sign != $r->SIGN) die('wrong sign');

		$unique_id = $r->MERCHANT_ORDER_ID;
		$amount = $r->AMOUNT;

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

	}

	public function resultRukassa(Request $r){
		$unique_id = $r->order_id;
		$amount = $r->amount;

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

		return 'OK';
	}

	public function resultExwave(){
		$entity_body = file_get_contents('php://input');
		$r = json_decode($entity_body, 1);

		$unique_id = $r['pay_id'];
		$amount = $r['amount'];

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

		return 'OK';
	}

	public function resultRubpay(Request $r){
		$unique_id = $r->order_id;
		$amount = $r->amount;

		$hash = md5("1127" . $r->order_id . $r->payment_id . $r->amount . $r->currency . $r->status . "7a7673d6ac1954015da6d344beeeff7e");
        if($hash != $_POST['hash']) die("wrong sign");

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

		return 'OK';
	}

	public function resultQpay(Request $r){
		$unique_id = $r->order;
		$amount = $r->sum;

		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();

		if($pay->status == 1){
			die('Ошибка');
		}
		
		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$pay->status = 1;


		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();



		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;
			$user_ref->save();
		}

		return 'OK';
	}

	public function resultPiastrix(Request $r){
		function getIP() {
			$ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
			return $ip;
		}
		if (!in_array(getIP(), array('51.68.53.104', '51.68.53.105', '51.68.53.106', '51.68.53.107', '37.48.108.180', '37.48.108.181'))){


			die("hacking attempt!".getIP());
		} 
		$unique_id = $r->shop_order_id;


		$payment_count = Payment::where('transaction', $unique_id)->count();
		if($payment_count == 0){
			die('Ошибка');
		}
		$pay = Payment::where('transaction', $unique_id)->first();
		if($pay->status == 1){
			die('Ошибка');
		}

		$pay->status = 1;
		$amount = $pay->sum;

		$percent = $pay->percent;
		$amount = $amount + ($amount * $percent / 100);
		$user_id = $pay->user_id;

		$user = User::where('id', $user_id)->first();
		$ref_id = $user->ref_id;

		$pay->afterpay = $user->balance + $amount;
		$pay->save();

		$user_status = $user->status;
		$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
		$now_st = $user_status;
		$max_id = Status::max('id');
		if($max_id != $user_status){
			$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
			foreach ($statuses as $st) {
				if($user_deps >= $st->deposit){
					$now_st = $st->id;
				}
			}
		}	

		$update_status = $now_st - $user_status;
		if($update_status > 0){
			self::statusBonus($user_status, $now_st, $user_id);
		}

		$user = User::where('id', $user_id)->first();
		if($user->deps == 0 and $user->balance > 5){
			$user->bonus_up = 1;
		}else{
			$user->bonus_up = 0;
		}
		$user->balance += $amount;
		$user->deps += $amount;
		$user->sum_to_withdraw += ($amount * 1.1 - $amount);
		$user->save();

		if($ref_id > 0){
			$user_ref = User::where('id', $ref_id)->first();
			$percent_ref = $user_ref->ref_coeff;

			$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
			$user_ref->profit += ($amount * $percent_ref / 100);
			$user_ref->balance_ref += ($amount * $percent_ref / 100);
			// $user_ref->balance = $balance_ref;

			$user_ref->save();
		}

		die('OK');
	}

	public function statusBonus($now, $need_plus, $user_id)
	{
		$now = $now;
		$need_plus = $need_plus;
		for ($i=$now; $i < $need_plus; $i++) { 
			$st_id = $i + 1;
			$status = Status::where('id', $st_id)->first();
			$bonus = $status->bonus;
			$user = User::where('id', $user_id)->first();
			$user->balance += $bonus;
			$user->status += 1;
			$user->save();
		}
	}

	public function result(){
		$setting = Setting::first();

		$unique_id = $_GET['unique_id']; 
		$sign = $_GET['sign']; 
		$description = $_GET['description']; 
		$amount = $_GET['amount'];

		$my_token = $setting->gamepay_api_key; 
		$my_shop_id = $setting->gamepay_shop_id; 
		$amount = number_format($amount, 2, '.', '');
		$my_sign = hash('sha256', "{$unique_id}:{$amount}:{$my_token}:{$my_shop_id}");

		if ($sign == $my_sign){
			$payment_count = Payment::where('transaction', $unique_id)->count();
			if($payment_count == 0){
				die('Ошибка');
			}
			$pay = Payment::where('transaction', $unique_id)->first();
			if($pay->status == 1){
			die('Ошибка');
		}
			$pay->status = 1;
			
			$percent = $pay->percent;
			$amount = $amount + ($amount * $percent / 100);
			$user_id = $pay->user_id;

			$user = User::where('id', $user_id)->first();
			$ref_id = $user->ref_id;

			$pay->afterpay = $user->balance + $amount;
			$pay->save();

			$user_status = $user->status;
			$user_deps = $user->deps + $amount;

			// $now_status = Status::where('deposit', '>=', $amount)->where('deposit', '<', $amount)->orderBy('id', 'desc')->first();
			$now_st = $user_status;
			$max_id = Status::max('id');
			if($max_id != $user_status){
				$statuses = Status::where('id', '>', $user_status)->orderBy('id', 'asc')->get();
				foreach ($statuses as $st) {
					if($user_deps >= $st->deposit){
						$now_st = $st->id;
					}
				}
			}	

			$update_status = $now_st - $user_status;
			if($update_status > 0){
				self::statusBonus($user_status, $now_st, $user_id);
			}

			$user = User::where('id', $user_id)->first();
			if($user->deps == 0 and $user->balance > 10){
				$user->bonus_up = 1;
			}else{
				$user->bonus_up = 0;
			}
			$user->balance += $amount;
			$user->deps += $amount;
			if($user->sum_to_withdraw < 0){
				$user->sum_to_withdraw = 0;
			}
			$user->sum_to_withdraw += ($amount * 1.1 - $amount);
			$user->save();

			if($ref_id > 0){
				$user_ref = User::where('id', $ref_id)->first();
				$percent_ref = $user_ref->ref_coeff;

				$balance_ref = $user_ref->balance + ($amount * $percent_ref / 100);
				$user_ref->profit += ($amount * $percent_ref / 100);
				// $user_ref->balance = $balance_ref;
				$user_ref->balance_ref += ($amount * $percent_ref / 100);
				$user_ref->save();
			}

		}else{
			die("Недействительная подпись");
		}
	}

	public function requestGamePay($type, $params){
		$url = 'https://oplatalift.site/api/'.$type; 

		$result = file_get_contents($url, false, stream_context_create(array( 
			'http' => array( 
				'method' => 'POST', 
				'header' => 'Content-type: application/x-www-form-urlencoded', 
				'content' => http_build_query($params) 
			) 
		))); 

		$response = json_decode($result, true); 
		return $response;
	}
	public function checkStatus(Request $r){
		$id = $r->id;
		$setting = Setting::first();
		$params = array( 
			'vip_id' => 4,
			'order_id'=> $id,
			'token'=> $setting->gamepay_api_key
		);
		$resp = self::requestGamePay('checkStatus', $params);
		$status = $resp['data']['status'];
		if($status == 0){
			return response(['success' => false, 'mess' => 'Перевод не найден']);
		}
		return response(['success' => true]);
	}
	public function go(Request $r){
		$sum = $r->sum;
		$system = $r->system;
		$promo = $r->promo;	

		if(!is_numeric($sum)){
			return response(['success' => false, 'mess' => 'Введите корректно сумму пополнения']);
		}

		if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

		$user = \Auth::user();
if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
		$countSystemDep = SystemDep::where('id', $system)->count();
		if($countSystemDep == 0){
			return response(['success' => false, 'mess' => 'Ошибка']);
		}

		//if($user->admin == 3) return response(['success' => false, 'mess' => 'Ошибка']);

		$systemDep = SystemDep::where('id', $system)->first();
		$minDep = $systemDep->min_sum;
		$psDep = $systemDep->ps;
		$number_ps = $systemDep->number_ps;
		$img = $systemDep->img;

		if($sum < $minDep){
			return response(['success' => false, 'mess' => "Минимальная сумма пополнения {$minDep}р."]);
		}

		$percent = 0;

		if($promo != ''){
			$deppromo_count = DepPromo::where('name', $promo)->count();
			if($deppromo_count == 0){
				return response(['success' => false, 'mess' => 'Промокод не найден или закончился' ]);
			}

			$promo_act_count = ActivePromo::where('promo', $promo)->where('user_id', $user->id)->count();
			if ($promo_act_count > 0)  {   
				return response(['success' => false, 'mess' =>  "Вы уже использовали этот код"]);
			}
			$deppromo = DepPromo::where('name', $promo)->first();
			$start = $deppromo->start;
			$end = $deppromo->end;
	        $active = $deppromo->active;//ALL
	        $actived = $deppromo->actived;
	        $percent = $deppromo->percent;
	        $now_time = time();
	        $start = strtotime($start);
	        $end = strtotime($end);

	        if($actived == $active){
	        	return response(['success' => false, 'mess' => 'Промокод не найден или закончился' ]);
	        }

	        if($now_time < $start){
	        	return response(['success' => false, 'mess' => 'Промокод будет доступен '.date('d.m в H:i', $start) ]);
	        }


	        if($now_time > $end){
	        	return response(['success' => false, 'mess' => 'Промокод не найден или закончился' ]);
	        }

	        $deppromo->actived += 1;
        	$deppromo->save();

        	ActivePromo::create(array(
            'promo'  => $promo,
            'user_id'=> $user->id,
            'type_promo' => 1,
            'promo_id' => $deppromo->id,
        ));

    }

    $setting = Setting::first();

    $unique_id = time() * $user->id;
    $modal = 0;
    $transfer = 'false';
    if($psDep == 1){
			// FreeKassa
    	$merchant_id = $setting->fk_id;
    	$secret_word = $setting->fk_secret_1;
    	$order_id = $unique_id;
    	$order_amount = $sum;
    	$currency = 'RUB';
    	$sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$currency.':'.$order_id);
    	
    	$link = "https://pay.freekassa.ru?m=".$merchant_id."&oa={$order_amount}&o={$order_id}&currency=RUB&s=".$sign."";
    }

    if($psDep == 2){
		$curl = curl_init();
		curl_setopt_array($curl, [
  			CURLOPT_URL => 'https://api.qpay.su/v1/deposit',
  			CURLOPT_RETURNTRANSFER => true,
 			CURLOPT_CUSTOMREQUEST => 'POST',
  			CURLOPT_POSTFIELDS => json_encode([
    			'order' => (string) $unique_id,
    			'type' => 'sum',
    			'format' => 'json',
    			'method' => 'mnl',
    			'sum' => $sum
  			]),
  			CURLOPT_HTTPHEADER => [
    			'Authorization: Bearer',
    			'Content-Type: application/json'
  			],
		]);
		$response = json_decode(curl_exec($curl));
		curl_close($curl);

		$arub = floor($response->data->sum);
		$acop = ($response->data->sum - $arub) * 100;

		$link = "https://qiwi.com/payment/form/99?extra%5B%27account%27%5D=". $response->data->person ."&amountInteger=". $arub ."&amountFraction=". $acop ."&currency=643&blocked[0]=sum&blocked[1]=account";
    }

	if($psDep == 4){
		// Rukassa
		$data = [
            'shop_id'	=> 486,
            'token'		=> '',
            'order_id' 	=> $unique_id,
            'amount' 	=> $sum,
            'method' => $number_ps == 0 ? 'card' : ($number_ps == 1 ? 'sbp' : 'crypta')
        ];

		$ch = curl_init('https://lk.rukassa.pro/api/v1/create');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $result = json_decode(curl_exec($ch));
        curl_close($ch);

        $link = $result->url;
	}

	if($psDep == 5){
		$url = "https://api.exwave.io/create/";
        $dataFields = array(
            "method" => $number_ps == 0 ? 'card' : ($number_ps == 1 ? 'qiwi' : 'USDTTRC20'),
            "order_id" => $unique_id,
            "amount" => $sum,
            "token" => ""
        );

		$result = json_decode(file_get_contents($url . "?" . http_build_query($dataFields)));

		$link = $result->url;
	}

	if($psDep == 6){
		$payload = http_build_query([
			'project_id' => 1127,
			'amount' => $sum,
			'order_id' => $unique_id,
			'sign' => md5("". "1127" . $unique_id . $sum . "1" . ""),
			'payment_method' => $number_ps
		]);

		$link = "https://rubpay.ru/pay/create?". $payload;
	}

    Payment::create(array(
    	'user_id' => $user->id,
    	'login' => $user->name, 
    	'avatar' => $user->avatar,
    	'sum' => $sum,
    	'data' => date('d.m.Y H:i'),
    	'transaction' => $unique_id,
    	'beforepay' => $user->balance,
    	'percent' => $percent,
    	'img_system' => $img
    ));

    return response(['success' => true, 'link' => $link, 'modal' => $modal, 'transfer' => $transfer, 'img' => $img]);
}


}
