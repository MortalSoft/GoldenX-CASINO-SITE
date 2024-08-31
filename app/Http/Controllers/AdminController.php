<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Redis;
use App\Payment;
use App\Promo;
use App\User;
use App\RandomKey;
use App\DepPromo;
use App\Withdraw;
use App\ActivePromo;
use App\Setting;
use App\SystemWithdraw;
use App\SystemDep;
use App\Authorization;
use App\Status;
use App\Repost;
use App\Tourniers;

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

class AdminController extends Controller
{
    const STEP_USER = 15;

    public function __construct(){
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function createTournier(Request $r){

        $name = $r->name;
        $places = $r->places;
        $prizes = $r->prizes;
        $start = strtotime($r->start);
        $end = strtotime($r->end);
        
        $game_id = $r->game_id;
        $desc = $r->desc;

        $game_m = [['Crazy Shoot', 'shoot'], ['Mines', 'mines'], ['X100', 'x100']];

        $game = $game_m[$game_id][0];
        $class = $game_m[$game_id][01];

        $prize = array_sum($prizes);
           
        $tournier = Tourniers::create(array(
            'name' => $name,
            'places' => $places,
            'prizes' => json_encode($prizes),
            'start' => $start,
            'end' => $end,
            'class' => $class,
            'game' => $game,
            'game_id' => $game_id,
            'description' => $desc,
            'prize' => $prize,
        ));

        $time = time();

        $time_go = $start - $time;
        if($time_go < 0){
            $time_go = 0;
        }

        $time_go_end = $end - $time;

        $client = new Client(new Version2X('https://localhost:2083', [
            'headers' => [
                'X-My-Header: websocket rocks'
            ],
            'context' => ['ssl' => ['verify_peer_name' =>false, 'verify_peer' => false]]
        ]));

        $client->initialize();
        $client->emit('updateTournier', [
            'id' => $tournier->id,
            'time_to_type_1' => $time_go,
            'time_to_type_2' => $time_go_end,

        ]);
        $client->close();

        // \App\Jobs\UpdateTournier::dispatch(['id' => $tournier->id, 'type' => 1])->delay(now()->addSeconds($time_go));

        // \App\Jobs\UpdateTournier::dispatch(['id' => $tournier->id, 'type' => 2])->delay(now()->addSeconds($time_go_end));

        return response(['success' => true, 'mess' => 'Успешно' ]);

    }

    public function addSystemWithdraw(Request $r){
        $img = $r->img;
        $min = $r->min_sum;
        $comm_percent = $r->comm_percent;
        $comm_rub = $r->comm_rub;
        $name = $r->name;

        SystemWithdraw::create(array(
            'name' => $name,
            'min_sum' => $min,
            'comm_percent' => $comm_percent,
            'comm_rub' => $comm_rub,
            'img' => $img,
            'color' => $r->color
        ));

        return response(['success' => true, 'mess' => 'Успешно' ]);

    }

    public function deleteSystemWithdraw(Request $r){
        $id = $r->id;
        SystemWithdraw::where('id', $id)->delete();
        return response(['success' => true, 'mess' => 'Успешно' ]);
    }

    public function saveSystemWithdraw(Request $r){
        $id = $r->id;
 
        $systemwithdraw = SystemWithdraw::where('id', $id)->first();
        $systemwithdraw->img = $r->img;
        $systemwithdraw->min_sum = $r->min_sum;
        $systemwithdraw->comm_percent = $r->comm_percent;
        $systemwithdraw->comm_rub = $r->comm_rub;
        $systemwithdraw->name = $r->name;
        $systemwithdraw->color = $r->color;
        $systemwithdraw->save();

        return response(['success' => true, 'mess' => 'Успешно' ]);


    }


    public function addSystemDeposit(Request $r){
        $img = $r->img;
        $min = $r->min_sum;
        $comm_percent = $r->comm_percent;
        $name = $r->name;
        $ps = $r->ps;
        $number_ps = $r->number_ps;

        SystemDep::create(array(
            'name' => $name,
            'min_sum' => $min,
            'comm_percent' => $comm_percent,
            'img' => $img,
            'ps' => $ps,
            'number_ps' => $number_ps,
            'color' => $r->color
        ));

        return response(['success' => true, 'mess' => 'Успешно' ]);
    }

    public function deleteSystemDeposit(Request $r){
        $id = $r->id;
        SystemDep::where('id', $id)->delete();
        return response(['success' => true, 'mess' => 'Успешно' ]);
    }


    public function saveSystemDeposit(Request $r){
        $img = $r->img;
        $min = $r->min_sum;
        $comm_percent = $r->comm_percent;
        $name = $r->name;
        $ps = $r->ps;
        $id = $r->id;
        $number_ps = $r->number_ps;
        $off = $r->off;

        $systemdep = SystemDep::where('id', $id)->first();
        $systemdep->img = $img;
        $systemdep->min_sum = $min;
        $systemdep->comm_percent = $comm_percent;
        $systemdep->name = $name;
        $systemdep->ps = $ps;
        $systemdep->number_ps = $number_ps;
        $systemdep->off = $off;
        $systemdep->color = $r->color;
        $systemdep->sort = $r->sort;
        $systemdep->save();

        return response(['success' => true, 'mess' => 'Успешно' ]);
    }


    public function changeWithdraw(Request $r){
        $id = $r->id;
        $status = $r->status;

        $info = Withdraw::where('id', $id)->first();
        if($info->status != 0){
            return response(['success' => false, 'mess' => 'Выплата отменена или отправлена' ]);

        }

        if($status == 1){
            Withdraw::where('id', $id)->update(['status' => $status]);
            $info = Withdraw::where('id', $id)->first();
            $user_id = $info->user_id;
            $sum_full = $info->sum_full;

            if($info->ps == "Qiwi" || $info->ps == "VISA") {
                $sign = md5("7a7673d6ac1954015da6d344beeeff7e" . "1127" . $info->sum . $info->id . "1" . ($info->ps == "Qiwi" ? "5" : "1") . $info->wallet . "1" . "7a7673d6ac1954015da6d344beeeff7e");

                $url = "https://rubpay.ru/pay/withdraw";
                $dataFields = array(
                    "project_id" => 1127,
                    "order_id" => $info->id,
                    "amount" => $info->sum,
                    "sign" => $sign,
                    "currency" => 1,
                    "payment_method" => ($info->ps == "Qiwi" ? "5" : "1"),
                    "wallet" => $info->wallet,
                    "withdraw_type" => 1,
                    "notify_url" => "https://blupper.win/withdrawRub"
                );

                $result = json_decode(file_get_contents($url . "?" . http_build_query($dataFields)));

                if($result->result == 0) {
                    Withdraw::where('id', $id)->update(['status' => 0]);
                    return response(['success' => false, 'mess' => $result->error]);
                }

                $user = User::where('id', $user_id)->first();
                $user->withdraws += $sum_full;
                $user->save();
                
                Withdraw::where('id', $id)->update(['status' => 3]);

                return response(['success' => true, 'mess' => 'Выплата поставлена в обработку' ]);
            }

            $user = User::where('id', $user_id)->first();
            $user->withdraws += $sum_full;
            $user->save();
        }
        if($status == 2){
            Withdraw::where('id', $id)->update(['status' => $status]);
            $info = Withdraw::where('id', $id)->first();
            $user_id = $info->user_id;
            $sum_full = $info->sum_full;
            $user = User::where('id', $user_id)->first();
            $user->balance += $sum_full;
            $user->save();
        }
        return response(['success' => true, 'mess' => 'Успешно' ]);

    }

    public function resetBank(Request $r){
        $type = $r->type;

        $setting = Setting::first();

        if($type == "dice"){
            \Cache::put('diceGame.bank', 200);
            \Cache::put('diceGame.profit', 0);
        }

        if($type == "mines"){
            \Cache::put('minesGame.bank', 200);
            \Cache::put('minesGame.profit', 0);
        }

        if($type == "coin"){
            \Cache::put('coinGame.bank', 200);
            \Cache::put('coinGame.profit', 0);
        }

        if($type == "shoot"){
            $setting->shoot_bank = 200;
            $setting->shoot_profit = 0;
        }

        if($type == "wheel"){
            $setting->wheel_bank = 200;
            $setting->wheel_profit = 0;
        }

        if($type == "crash"){
            $setting->crash_bank = 200;
            $setting->crash_profit = 0;
        }

        $setting->save();

        return response(['success' => true, 'mess' => 'Успешно' ]);


    }

    public function saveSetting(Request $r){
        $setting = Setting::first();
        $type = $r->type;

        if($type == 1){
            $setting->name = $r->name;
            $setting->group_id = $r->group_id;
            $setting->group_token = $r->group_token;
            $setting->tg_id = $r->tg_id;
            $setting->tg_bot_id = $r->tg_bot_id;
            $setting->tg_token = $r->tg_token;
            $setting->bonus_reg = $r->bonus_reg;
            $setting->bonus_group = $r->bonus_group;
            $setting->dep_transfer = $r->dep_transfer;
            $setting->dep_createpromo = $r->dep_createpromo;
            $setting->meta_tags = $r->meta_tags;
            $setting->max_withdraw_bonus = $r->max_withdraw_bonus;
            $setting->theme = $r->theme;
        }

        if($type == 2){
            $setting->fk_id = $r->fk_id;
            $setting->fk_secret_1 = $r->fk_secret_1;
            $setting->fk_secret_2 = $r->fk_secret_2;
        }

        if($type == 3){
            $setting->piastrix_id = $r->piastrix_id;
            $setting->piastrix_secret = $r->piastrix_secret;
        }

        if($type == 4){
            $setting->prime_id = $r->prime_id;
            $setting->prime_secret_1 = $r->prime_secret_1;
            $setting->prime_secret_2 = $r->prime_secret_2;
        }

        if($type == 5){
            $setting->linepay_id = $r->linepay_id;
            $setting->linepay_secret_1 = $r->linepay_secret_1;
            $setting->linepay_secret_2 = $r->linepay_secret_2;
        }

        if($type == 6){
            $setting->paypaylych_id = $r->paypaylych_id;
            $setting->paypaylych_token = $r->paypaylych_token;
        }

        if($type == 7){
            $setting->aezapay_id = $r->aezapay_id;
            $setting->aezapay_token = $r->aezapay_token;
        }

        
        $setting->save();

        return response()->json(['success' => true, 'mess' => 'Успешно' ], 200);
    }


    public function deleteDepPromo(Request $r){
        if(\Auth::user()->admin == 2) return response()->json(['message' => 'Ошибка'], 401);
        $id = $r->id;
        DepPromo::where('id', $id)->delete();
        return response()->json(['success' => true, 'mess' => 'Успешно' ], 200);
    }


    public function createDepPromo(Request $r){
        $name = $r->name;
        $sum = $r->percent;
        $act = $r->active;

        $count_promo = DepPromo::where('name', $name)->count();
        if($count_promo > 0){
            return response()->json(['message' => 'Такой промокод уже есть' ], 401);
        }
        if($name == ''){
            return response()->json(['message' => 'Не указано название' ], 401);
        }
        if($sum < 1){
            return response()->json(['message' => '% меньше 1' ], 401);
        }
        if($act < 1){
            return response()->json(['message' => 'Активация меньше 1' ], 401);
        }

        if(\Auth::user()->admin == 2 && $sum > 30) return response()->json(['message' => 'Максимальный процент 30'], 401);

        $start = date("Y-m-d H:i");            
        $end = date("Y-m-d H:i", time() + 31536000);
        

        $user = \Auth::user();

        DepPromo::create(array(
            'name' => $name,
            'percent' => $sum,
            'active' => $act,
            'start' => $start,
            'end' => $end,
            'user_id' => $user->id,
            'user_name' => $user->name
        ));

        return response()->json(['success' => true, 'mess' => 'Успешно' ], 200);
    }

    public function deletePromo(Request $r){
        if(\Auth::user()->admin == 2) return response()->json(['message' => 'Ошибка'], 401);
        $id = $r->id;
        $promo = Promo::where('id', $id)->first();
        $name = $promo->name;

        Promo::where('id', $id)->delete();
        \Cache::put('promo.name.'.$name, '', 0);

        return response()->json(['success' => true, 'mess' => 'Успешно' ], 200);
    }

    public function createPromo(Request $r){
        $name = $r->name;
        $sum = $r->sum;
        $act = $r->active;

        $count_promo = Promo::where('name', $name)->count();
        if(\Cache::has('promo.name.'.$name)){
            return response()->json(['message' => 'Такой промокод уже есть' ], 401);
        }
        if($name == ''){
            return response()->json(['message' => 'Не указано название' ], 401);
        }
        if($sum < 1){
            return response()->json(['message' => 'Сумма меньше 1' ], 401);
        }
        if($act < 1){
            return response()->json(['message' => 'Активация меньше 1' ], 401);
        }  

        if(\Auth::user()->admin == 2 && $sum > 50) return response()->json(['message' => 'Максимальная сумма 50'], 401);

        $user = \Auth::user();

        $promocode = Promo::create(array(
            'name' => $name,
            'sum' => $sum,
            'active' => $act,
            'user_id' => $user->id,
            'user_name' => $user->name,
        ));

        \Cache::put('promo.name.'.$name, '1');
        \Cache::put('promo.name.'.$name.'.active', $act);
        \Cache::put('promo.name.'.$name.'.active.count', 0);
        \Cache::put('promo.name.'.$name.'.sum', $sum);

        return response()->json(['success' => true, 'mess' => 'Успешно' ], 200);
    }

    public function changeBan(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->ban = $request->type;
        $user->save();
    }

    public function deleteUser(Request $request)
    {
        User::where("id", $request->id)->delete();
    }

    public function saveUser(Request $request)
    {
        $user = User::where("id", $request->id)->first();
        $user->balance = $request->balance;
        $user->demo_balance = $request->demo_balance;
        $user->admin = $request->admin;
        $user->save();
    }

    public function changePay(Request $request)
    {
        $pay = Payment::where("id", $request->id)->first();
        $percent = $pay->percent;
        $amount = $pay->sum;
        $amount = $amount + ($amount * $percent / 100);
        $pay->status = 1;

        $user_id = $pay->user_id;

        $user = User::where('id', $user_id)->first();
        $ref_id = $user->ref_id;

        $pay->afterpay = $user->balance + $amount;
        $pay->save();

        $user_status = $user->status;
        $user_deps = $user->deps + $amount;


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
            $user_ref->save();
        }
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

    public function chart(Request $request)
    {
        $id = $request->id;

        $deps = [];
        $withdraws = [];
        $profit = [];
        $labels = [];

        if($id == 1){
            for ($i=0; $i < 24; $i++) { 
                $date_1 = date('Y-m-d').' '.$i.':00:00';
                $date_1 = strtotime($date_1);
                $date_2 = $date_1 + (60 * 60) - 1;

                $time_1 = date("Y-m-d H:i:s", $date_1);
                $time_2 = date("Y-m-d H:i:s", $date_2);

                $labels[] = $time_1;

                $deps[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $withdraws[] = Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $profit[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum') - Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
            }

            
        }

        if($id == 2){
            for ($i=0; $i < 7; $i++) { 
                $date_start = \Carbon\Carbon::now('Europe/Moscow')->startOfWeek();
                $date_start = strtotime($date_start) + (60 * 60 * 24 * $i);
                
                $date_1 = date("Y-m-d H:i:s", $date_start);
                $date_1 = strtotime($date_1);
                $date_2 = $date_1 + (60 * 60 * 24) - 1;

                $time_1 = date("Y-m-d H:i:s", $date_1);
                $time_2 = date("Y-m-d H:i:s", $date_2);
                $labels[] = $time_1;

                $deps[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $withdraws[] = Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $profit[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum') - Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
            }
        }

        if($id == 3){
            for ($i=1; $i < 32; $i++) { 
                $date_1 = date('Y-m').'-'.$i.' 00:00:00';
                $date_1 = strtotime($date_1);

                $date_2 = date('Y-m').'-'.($i + 1).' 00:00:00';
                $date_2 = strtotime($date_2) - 1;

                $time_1 = date("Y-m-d H:i:s", $date_1);
                $time_2 = date("Y-m-d H:i:s", $date_2);

                $labels[] = $time_1;

                $deps[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $withdraws[] = Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $profit[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum') - Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
            }
        }

        if($id == 4){
            for ($i=1; $i < 13; $i++) { 
                $date_1 = date('Y').'-'.$i.'-01 00:00:00';
                $date_1 = strtotime($date_1);

                $date_2 = date('Y').'-'.($i + 1).'-01 00:00:00';
                $date_2 = strtotime($date_2) - 1;

                $time_1 = date("Y-m-d H:i:s", $date_1);
                $time_2 = date("Y-m-d H:i:s", $date_2);

                $labels[] = $time_1;

                $deps[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $withdraws[] = Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
                $profit[] = Payment::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum') - Withdraw::where('status', 1)->whereBetween('created_at', [$time_1,$time_2])->sum('sum');
            }
        }

        $deps_n = array_sum($deps);
        $withdraws_n = array_sum($withdraws);
        $profit_n = array_sum($profit);

        return response()->json([
            'deps' => $deps,
            'withdraws' => $withdraws,
            'profit' => $profit,
            'labels' => $labels,
            'deps_n' => $deps_n,
            'withdraws_n' => $withdraws_n,
            'profit_n' => $profit_n
        ], 200);


    } 


    ///////////////////////////////////////////


    public function withdrawFkNoty(Request $r){
        $id_fk_w = $r->order_id;

        $st = $r->status;

        $withdraw = Withdraw::where('id_fk_w', $id_fk_w)->first();
        $withdraw->status = 1;
        if($st == 9){
           $withdraw->status = 0;
       }

       $withdraw->save();
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

public function gamepayAddWallet(Request $r){
    $type = $r->type;
    $setting = Setting::first();

    if($type == 'payeer'){
        $wallet = $r->wallet;
        $appid = $r->appid;
        $token = $r->token;

        $params = array( 
            'vip_id' => 4,
            'wallet' => $wallet,
            'appid' => $appid,
            'token_wallet' => $token,
            'type' => $type,
            'token'=> $setting->gamepay_api_key
        );

    }else{
        $wallet = $r->wallet;
        $token = $r->token;

        $params = array( 
            'vip_id' => 4,
            'wallet' => $wallet,
            'token_wallet' => $token,
            'type' => $type,
            'token'=> $setting->gamepay_api_key
        );
    }

    $resp = self::requestGamePay('vipAddWallet', $params);
    return response(['success' => true, 'resp' => $resp, 'params' => $params ]);
}

public function gamepayWallets(){
    $setting = Setting::first();
    $params = array( 
        'vip_id' => 4,
        'token'=> $setting->gamepay_api_key
    );
    $resp = self::requestGamePay('vipGetWallets', $params);
    $qiwi = $resp['data']['qiwi'];
    $yoomoney = $resp['data']['yoomoney'];
    $payeer = $resp['data']['payeer'];

    return response(['success' => true, 'qiwi' => $qiwi, 'yoomoney' => $yoomoney, 'payeer' => $payeer, 'resp' => $resp ]);

}


public function giveBonusMines(Request $r){
    $id = $r->id;
    $user = User::where('id', $id)->first();
    $user->bonusMine = 1;
    $user->save();

    return response(['success' => true, 'mess' => 'Успешно' ]);
}

public function giveBonusShoot(Request $r){
    $id = $r->id;
    $drop = $r->drop;
    $user = User::where('id', $id)->first();
    $user->shootDrop = $drop;
    $user->save();

    return response(['success' => true, 'mess' => 'Успешно' ]);

}

public function giveBonusCoin(Request $r){
    $id = $r->id;
    $user = User::where('id', $id)->first();
    $user->bonusCoin = 1;
    $user->save();

    return response(['success' => true, 'mess' => 'Успешно' ]);
}


public function editStatus(Request $r){
    $color = $r->color;
    $name = $r->name;
    $bonus = $r->bonus;
    $deposit = $r->deposit;
    $id = $r->id;

    $st = Status::where('id', $id)->first();
    $st->color = $color;
    $st->name = $name;
    $st->bonus = $bonus;
    $st->deposit = $deposit;
    $st->save();
    return response(['success' => true, 'mess' => 'Успешно' ]);
}

public function editRepost(Request $r){
    $color = $r->color;
    $repost_to = $r->repost;
    $bonus = $r->bonus;
    $id = $r->id;

    $st = Repost::where('id', $id)->first();
    $st->color = $color;
    $st->repost_to = $repost_to;
    $st->bonus = $bonus;
    $st->save();
    return response(['success' => true, 'mess' => 'Успешно' ]);
}

public function addRandom(Request $r){
    $name_key = $r->name_key;

    $count = RandomKey::where('name_key', $name_key)->count();
    if($count > 0){
        return response(['success' => false, 'mess' => 'Такой ключ уже есть' ]);
    }
    RandomKey::create(array(
        'name_key' => $name_key
    ));

    return response(['success' => true, 'mess' => 'Успешно' ]);

}

public function addStatus(Request $r){
    $color = $r->color;
    $name = $r->name;
    $bonus = $r->bonus;
    $deposit = $r->deposit;

    $count = Status::where('name', $name)->count();
    if($count > 0){
        return response(['success' => false, 'mess' => 'Такой статус уже есть' ]);
    }
    Status::create(array(
        'bonus' => $bonus,
        'deposit' => $deposit,
        'color' => $color,
        'name' => $name
    ));

    return response(['success' => true, 'mess' => 'Успешно' ]);

}



public function addRepost(Request $r){
    $color = $r->color;
    $bonus = $r->bonus;
    $repost = $r->repost;


    Repost::create(array(
        'bonus' => $bonus,
        'repost_to' => $repost,
        'color' => $color
    ));

    return response(['success' => true, 'mess' => 'Успешно' ]);
}





public function getDateFromDate(Request $r){
    $date = $r->date;
    $date_sec = strtotime($date);
    $date = date("Y-m-d H:i:s", $date_sec);
    return response(['success' => true, 'date' => $date ]);

}

public function infoUser(Request $r){
    $id = $r->id;
    $user = User::where('id', $id)->first();
    return response(['success' => true, 'user' => $user ]);

}

// public function saveUser(Request $r){
//     $id = $r->id;
//     $user = User::where('id', $id)->first();
//     $user->chat_ban = $r->chat_ban;
//     $user->why_ban = $r->why_ban;
//     $user->ban = $r->ban;
//     $user->balance = $r->balance;
//     $user->admin = $r->admin;
//     $user->name = $r->name;
//     $user->avatar = $r->avatar;
//     $user->save();
//     return response(['success' => true,'type'=> 'success', 'mess' => "Успешно" ]);

// }

public function updateAuto(Request $r){
    $type = $r->type;
    $game = $r->game;
    $setting = Setting::first();
    if($game == 'dice'){
        $setting->auto_dice = $type;
    }
    if($game == 'mines'){
        $setting->auto_mines = $type;
    }
    if($game == 'wheel'){
        $setting->auto_wheel = $type;
    }
    $setting->save();

    return response(['success' => true,'type'=> 'success', 'mess' => "Успешно" ]);
}

public function loadUser(Request $r){
    $id = $r->id;
    $user = \Auth::user();
    $user_id = $user->id;
    if($id == ''){
        $id = \Cache::get('admin.'.$user_id.'.loadUser.id');
        if(!(\Cache::has('admin.'.$user_id.'.loadUser.id'))){$id = 1; \Cache::put('admin.'.$user_id.'.loadUser.id', 1,600); } 
    }
    \Cache::put('admin.'.$user_id.'.loadUser.id', $id, 600);

    $user = User::where('id', $id)->first();

    if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); } 

    $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');
    $cashe_hist_u = json_decode($cashe_hist_user);
    $cashe_hist_user = json_decode($cashe_hist_user);
    $cashe_hist_user = array_reverse($cashe_hist_user);
    if(!(\Cache::has('admin.historyBalance.user.'.$user->id.'.step'))){ \Cache::put('admin.historyBalance.user.'.$user->id.'.step', 0, 300); }

    $step = \Cache::get('admin.historyBalance.user.'.$user->id.'.step');
    $cashe_hist_user_m = array_slice($cashe_hist_user, $step, 15);
    $count_hist_user = count($cashe_hist_user);
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_hist_user);       

    $step = $step / self::STEP_USER;

    $transfers = [];
    foreach ($cashe_hist_user as $t) {
        $mystring = $t->type;
        $findme = 'еревод';
        $pos = strpos($mystring, $findme);
        if ($pos !== false) {
            $transfers[] = $t;
        }
    }

    $videocards = Authorization::where('user_id', $user->id)->get();
    $videocard_s = [];
    foreach ($videocards as $v) {
        $videocard_s[] = $v->videocard.'<b> IP: '.$v->ip.'</b>';
    }

    $videocards = array_unique($videocard_s);
    $videocards = array_values($videocards);

    $deps = Payment::where('user_id', $user->id)->where('status', 1)->orderBy('id', 'desc')->get();
    $withdraws = Withdraw::where('user_id', $user->id)->where('status', 1)->orderBy('id', 'desc')->get();

    return response(['deps' => $deps, 'withdraws' => $withdraws, 'success' => true,'step' => $step,'paginate' => json_encode($paginate), 'user' => $user, 'cashe_hist_user_m' => $cashe_hist_user_m, 'transfers' => $transfers, 'videocards' => $videocards ]);
}

public function searchMultUser(Request $r){
    $id = $r->id;
    $user = User::where('id', $id)->first();
    $ip_user = $user->ip;
    $videocard_user = $user->videocard;
    $id_user = $user->id;

    $videocards = Authorization::where('user_id', $user->id)->get();
    $videocard_s = [];
    foreach ($videocards as $v) {
        $videocard_s[] = $v->videocard;
    }

    $videocards = array_unique($videocard_s);
    $videocards = array_values($videocards);


    $wallets_user = [];
    $wallets = Withdraw::where('user_id', $id_user)->get();
    foreach ($wallets as $wallet) {
        $wallets_user[] = $wallet->wallet;
    }
    $wallets_user = array_unique($wallets_user);


    $mults = [];
    $mults_wallet = [];
    $wallets_other = Withdraw::whereIn('wallet', $wallets_user)->where('user_id', '!=', $id_user)->get();
    foreach ($wallets_other as $wallet_other) {
        $mults[] = $wallet_other->user_id;
        $mults_wallet[] = $wallet_other->user_id;

    }

    $user_ip_mult = User::where('ip', $ip_user)->where('id', '!=', $id_user)->get();
    foreach ($user_ip_mult as $user_ip) {
        if(in_array($user_ip->videocard, $videocards)){
            $mults[] = $user_ip->id;
        }
    }

    $ips_auth = [];

    $auth_user = Authorization::where('user_id', $id_user)->get();
    foreach ($auth_user as $au) {
        $ipu = $au->ip;
        if(in_array($au->videocard, $videocards)){
            $us = Authorization::where('ip', $ipu)->where('user_id', '!=', $id_user)->get(); 
            foreach ($us as $u) {
                if(in_array($u->videocard, $videocards)){
                    $mults[] = $u->user_id;
                }
            }
        }
    }

        // $user_auth_mult = Authorization::where('id', '!=', $id_user)->where(['ip' => $ip_user])->get();
        // foreach ($user_auth_mult as $user_auth) {
        //     $mults[] = $user_auth->id;
        // }

    $mults_new = array_unique($mults);

    $mults_new_wallet = array_unique($mults_wallet);

    $user_mult = User::whereIn('id', $mults_new)->get();
    $user_mult_wallet = User::whereIn('id', $mults_new_wallet)->get();




    return response(['success' => true, 'mults' => $user_mult, 'mults_wallet' => $user_mult_wallet]);

}



public function infoPromo(Request $r){
    $type = $r->type;
    $name = $r->name;
    if($type == 0){
        $promo = Promo::where('name', $name)->first();
    }else{
        $promo = DepPromo::where('name', $name)->first();
    }
    return response(['success' => true, 'promo' => $promo ]);

}



public function deleteStatus(Request $r){
    $id = $r->id;
    Status::where('id', $id)->delete();
    return response(['success' => true, 'mess' => 'Успешно' ]);
}

public function deleteRepost(Request $r){
    $id = $r->id;
    Repost::where('id', $id)->delete();
    return response(['success' => true, 'mess' => 'Успешно' ]);
}






public function saveBan(Request $r){
    $id = $r->id;
    $type = $r->type;
    $why = $r->why;

    $user = User::where('id', $id)->first();
    $user->ban = $type;
    $user->why_ban = $why;
    $user->save();
    return response(['success' => true, 'mess' => 'Успешно' ]);

}

public function searchUser(Request $r){
    $text = $r->text;
    $users = User::where('id', $text)->orWhere('name', 'LIKE', "%{$text}%")->orWhere('ip', 'LIKE', "%{$text}%")->orWhere('vk_id', $text)->orWhere('videocard', $text)->get();
    return response(['success' => true, 'users' => $users ]);


}
public function generatePanigate($on_one_page, $now_page, $things){
    $paginate = [];

    if(ceil($things / $on_one_page) > 2 and $now_page > 1){
        $paginate[] = $now_page / $on_one_page;
    }
    $paginate[] = $now_page / $on_one_page + 1;
    if(ceil($things / $on_one_page) > 2 and $now_page > 0){
        $paginate[] = $now_page / $on_one_page + 2;
    }


    if(ceil($things / $on_one_page) <= 12){
        for ($i=1; $i <= ceil($things / $on_one_page); $i++) { 
            $paginate[] = $i;
        }
    }else{
        if($now_page < 5){
            for ($i = 1; $i <= 6; $i++) { 
                $paginate[] = $i;
            }
            $paginate[] = '...';

            for ($i = ceil($things / $on_one_page) - 2; $i < ceil($things / $on_one_page); $i++) { 
                $paginate[] = $i;
            }

        }
        else{
            for ($i = 1; $i <= 2; $i++) { 
                $paginate[] = $i;
            }

            $paginate[] = '...';

                // for ($i = $now_page; $i <= $now_page + 2; $i++) { 
                //     $paginate[] = $i;
                // }



            for ($i = ceil($things / $on_one_page) - 2; $i < ceil($things / $on_one_page); $i++) { 
                $paginate[] = $i;
            }
        }
    }

    if(count($paginate) == 1){
        $paginate = [];
    }

    return $paginate;
}




public function pageList(Request $r){
    $name = $r->name;
    $user_id = \Auth::user()->id;

    $page = $r->page;
    $step = \Cache::get('admin.'.$user_id.'.'.$name.'.step');
    $step_new = $page * self::STEP_USER;
    \Cache::put('admin.'.$user_id.'.'.$name.'.step', $step_new, 300);
    return response(['success' => true ]);
}

public function pageListUser(Request $r){
    $user_id = \Auth::user()->id;

    
    if(!(\Cache::has('admin.'.$user_id.'.loadUser.id'))){$id = 1; \Cache::put('admin.'.$user_id.'.loadUser.id', 1,600); } 
    $id = \Cache::get('admin.'.$user_id.'.loadUser.id');
    
    $page = $r->page;
    $step = \Cache::get('admin.historyBalance.user.'.$id.'.step');
    $step_new = $page * self::STEP_USER;
    \Cache::put('admin.historyBalance.user.'.$id.'.step', $step_new, 600);
    return response(['success' => true ]);
}

public function userAllTopRef(){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.userAllTopRef.step'))){ \Cache::put('admin.'.$user_id.'.userAllTopRef.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.userAllTopRef.step');
    $users = User::orderBy('refs', 'desc')->skip($step)->take(self::STEP_USER)->get();
    $count_user = User::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_user);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'users' => $users, 'paginate' => json_encode($paginate) ]);

}

public function userAllTopProfit(){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.userAllTopProfit.step'))){ \Cache::put('admin.'.$user_id.'.userAllTopProfit.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.userAllTopProfit.step');
    $users = User::orderBy('profit', 'desc')->skip($step)->take(self::STEP_USER)->get();
    $count_user = User::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_user);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'users' => $users, 'paginate' => json_encode($paginate) ]);

}

public function userAll(){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.userAll.step'))){ \Cache::put('admin.'.$user_id.'.userAll.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.userAll.step');
    $users = User::where('id', '>', $step)->take(self::STEP_USER)->get();
    $count_user = User::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_user);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'users' => $users, 'paginate' => json_encode($paginate) ]);

}

public function paymentsAll(){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.paymentsAll.step'))){ \Cache::put('admin.'.$user_id.'.paymentsAll.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.paymentsAll.step');
    $payments = Payment::orderBy('id', 'desc')->where('status', 1)->skip($step)->take(self::STEP_USER)->get();
    $count_user = Payment::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_user);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'payments' => $payments, 'paginate' => json_encode($paginate) ]);
}

public function withdrawsAll(Request $r){
    $user_id = \Auth::user()->id;
    $type = $r->type;
    $mult = $r->mult;

    if(!(\Cache::has('admin.'.$user_id.'.withdrawsAll.step'))){ \Cache::put('admin.'.$user_id.'.withdrawsAll.step', 0, 300); }

    if(!(\Cache::has('admin.'.$user_id.'.withdrawsAll.type'))){$type = 'all'; \Cache::put('admin.'.$user_id.'.withdrawsAll.type', 'all', 300); }




    $typeUser = \Cache::get('admin.'.$user_id.'.withdrawsAll.type');
    $multUser = \Cache::get('admin.'.$user_id.'.withdrawsAll.mult');

    if($type == ''){
        $type = $typeUser;
    }

    if($mult == ''){
        $mult = $multUser;
    }

    if($type != $typeUser){
        \Cache::put('admin.'.$user_id.'.withdrawsAll.step', 0, 300); 
    }

    if($mult != $multUser){
        \Cache::put('admin.'.$user_id.'.withdrawsAll.step', 0, 300); 
    }

    \Cache::put('admin.'.$user_id.'.withdrawsAll.type', $type, 300);
    \Cache::put('admin.'.$user_id.'.withdrawsAll.mult', $mult, 300);

    $step = \Cache::get('admin.'.$user_id.'.withdrawsAll.step');

    if($type == 'all'){
        $count_user = Withdraw::where('mult', $mult)->count();
        $withdraws = Withdraw::where('mult', $mult)->orderBy('id', 'desc')->skip($step)->take(self::STEP_USER)->get();
    }else{
        if($type == 1){                
            $withdraws = Withdraw::orderBy('updated_at', 'desc')->where('mult', 0)->where('status', $type)->skip($step)->take(self::STEP_USER)->get();
        }else{
            $withdraws = Withdraw::orderBy('id', 'desc')->where('mult', 0)->where('status', $type)->skip($step)->take(self::STEP_USER)->get();
        }
        $count_user = Withdraw::where('mult', 0)->where('status', $type)->count();

    }


    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_user);       

    $step = $step / self::STEP_USER;

    if($mult == 1){
        $type = 'mult';
    }
    return response(['success' => true,'type' => $type, 'step' => $step, 'withdraws' => $withdraws, 'paginate' => json_encode($paginate) ]);
}

public function promoAll(){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.promoAll.step'))){ \Cache::put('admin.'.$user_id.'.promoAll.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.promoAll.step');
    $promos = Promo::orderBy('id', 'desc')->skip($step)->take(self::STEP_USER)->get();
    $count_promo = Promo::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_promo);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'promo' => $promos, 'paginate' => json_encode($paginate) ]);
}

public function promoDepAll(Request $r){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.promoDepAll.step'))){ \Cache::put('admin.'.$user_id.'.promoDepAll.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.promoDepAll.step');
    $promos = DepPromo::orderBy('id', 'desc')->skip($step)->take(self::STEP_USER)->get();
    $count_promo = DepPromo::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_promo);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'promo' => $promos, 'paginate' => json_encode($paginate) ]);

}

public function promoHistoryAll(Request $r){
    $user_id = \Auth::user()->id;

    if(!(\Cache::has('admin.'.$user_id.'.promoHistoryAll.step'))){ \Cache::put('admin.'.$user_id.'.promoHistoryAll.step', 0, 300); }

    $step = \Cache::get('admin.'.$user_id.'.promoHistoryAll.step');
    $history = ActivePromo::orderBy('id', 'desc')->skip($step)->take(self::STEP_USER)->get();
    $count_promo = ActivePromo::count();
    $paginate = self::generatePanigate(self::STEP_USER, $step, $count_promo);       

    $step = $step / self::STEP_USER;
    return response(['success' => true, 'step' => $step, 'history' => $history, 'paginate' => json_encode($paginate) ]);

}

public function systemWithdrawsAll(){
    $systems = SystemWithdraw::all();
    return response(['success' => true, 'systems' => $systems ]);
}


public function systemDepsAll(){
    $systems = SystemDep::where('off', 0)->get();
    return response(['success' => true, 'systems' => $systems ]);
}

public function randomAll(){
    $keys = RandomKey::all();
    return response(['success' => true, 'keys' => $keys ]);
}

public function statusAll(){
    $status = Status::all();
    return response(['success' => true, 'status' => $status ]);
}
public function repostAll(){
    $repost = Repost::all();
    return response(['success' => true, 'repost' => $repost ]);
}
public function getChartStat(){

}


}
