<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Redis;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Setting;
use App\Withdraw;
use App\Authorization;
use App\ActivePromo;
use App\Payment;
use App\Wheel;
use App\X100;
use App\Promo;
use App\User;
use App\Crash;
use App\Shoot;
use Auth;
use VK\Client\VKApiClient;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->redis = Redis::connection();
        
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            view()->share('u', $this->user);
            return $next($request);
        });

        Carbon::setLocale('ru');
    }

    public function testPublishInGroup(){
        // $VK_KEY = ""; 
        // $VERSION = "5.81"; 
        // $publicID = -;
        // $vk = new VkApi($VK_KEY, $VERSION);
    }

    public function changeBalance(Request $r){

        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        $games_on = 0;
        if(\Cache::has('minesGame.user.'. $user->id.'start')){
            $games_on = \Cache::get('minesGame.user.'. $user->id.'start');
        }

        $games_on_c = 0;
        if(\Cache::has('coinGame.user.'. $user->id.'start')){
            $games_on_c = \Cache::get('coinGame.user.'. $user->id.'start');
        }

        $games_on_s = 0;
        if(\Cache::has('shootGame.user.'. $user->id.'start')){
            $games_on_s = \Cache::get('shootGame.user.'. $user->id.'start');
        }

        $games_on = Crash::where('user_id', $user->id)->count() + $games_on_s + Wheel::where('user_id', $user->id)->count() + X100::where('user_id', $user->id)->count() + $games_on + $games_on_c;

        if($games_on > 0){return response(['success' => false, 'mess' => 'У вас есть активные игры' ]);}

        $type =  $r->type;

        $user->type_balance = $type;
        $user->save();

        if($type == 1){
            $balance = $user->demo_balance;
        }else{
            $balance = $user->balance;
        }

        return response(['success' => true, 'balance' => $balance]);
    }

    public function winterStart(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        $id = round($r->id);
        if($id < 1 || $id > 16){
            return response(['success' => false, 'mess' => 'Ошибка' ]);
        }

        $setting = Setting::first();

        if($setting->newYear == 0 || $user->newYear == 1){
            return response(['success' => false, 'mess' => 'Ошибка' ]);
        }  

        $prize = [5,
                5,
                5,
                7,
                7,
                7,
                10,
                10,
                15,
                15,
                20,
                25,
                30,
                100,
                200,
                300];
        
        shuffle($prize);

        if($user->deps - $user->withdraws > 8000){
            $p = [100, 200, 300];
            $sum = $p[rand(0, 2)];
            $prize[$id - 1] = $sum;
        }else{
            $p = [5, 7, 10, 15, 20, 25, 50];
            $sum = $p[rand(0, 6)];
            $prize[$id - 1] = $sum;
        }

        $winSum = $sum;


        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $newb = $user->balance + $winSum;
        
        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Получение подарка',
            'balance_before' => $user->balance,
            'balance_after' => $newb,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $lastbalance = $user->balance;
        $newbalance = $lastbalance + $winSum;

        $user->newYear = 1;
        $user->balance += $winSum;
        $user->save();

        return response(['success' => 'Вы получили '.$winSum, 'prize' => $prize, 'lastbalance' => $lastbalance, 'newbalance' => $newbalance]);

        
    }

    public function addDemoBalance(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
        $addbalance = $r->addbalance;
        if($addbalance < 1){ return response(['success' => false, 'mess' => 'Минимальная сумма - 1р' ]);}
        if($addbalance > 25000){ return response(['success' => false, 'mess' => 'Максимальная сумма - 25000р' ]); }
        
        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $newb =  $user->demo_balance + $addbalance;
        
        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Получение демо баланса',
            'balance_before' => $user->demo_balance,
            'balance_after' => $newb,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $user->demo_balance += $addbalance;
        $user->save();

        return response(['success' => true, 'balance' => $user->demo_balance]);
    }

    public function updateCard(Request $r)
    {
        

        $video_card = $r->videocard;
        $video_card = json_decode($video_card);
        if(isset($video_card->error)){
            $video_card = "No card";
        }else{
            $video_card = $video_card->renderer;
        }

        $user = \Auth::user();
       
        Authorization::create(array(
            'user_id'  => $user->id,
            'ip' => $_SERVER['HTTP_CF_CONNECTING_IP'],
            'videocard' => $video_card
        ));

        $user = User::where('id', $user->id)->first();

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Получение видеокарты',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

       
        $user->videocard = $video_card;
        $user->save();

        return response(['success' => true]);
    }

    public function historyGames()
    {
        if(!(\Cache::has('games'))){
            \Cache::put('games', '[]');
            $history = []; 
        }

        $history = \Cache::get('games');
        $history = json_decode($history);

        return response(['success' => true, 'history' => $history ]);
    }

     public function refsChange(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        if($user->balance_ref < 5){return response(['success' => false, 'mess' => 'Минимум 5' ]);}

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $newb =  $user->balance + $user->balance_ref;
        
        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Обмен реферального баланса',
            'balance_before' => $user->balance,
            'balance_after' => $newb,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        

        $user->balance += $user->balance_ref;
        $user->balance_ref = 0;
        $user->save();

        return response(['success' => true, 'balance' => $newb ]);
    }


    public function repostChange(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        if($user->balance_repost < 5){return response(['success' => false, 'mess' => 'Минимум 5' ]);}

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $newb =  $user->balance + $user->balance_repost;
        
        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Обмен бонусного баланса',
            'balance_before' => $user->balance,
            'balance_after' => $newb,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        

        $user->balance += $user->balance_repost;
        $user->balance_repost = 0;
        $user->save();

        return response(['success' => true, 'balance' => $newb ]);
    }

    public function promoAct(Request $r){
        $name = $r->name;
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
        if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

                
        if(!\Cache::has('promo.name.'.$name)){
            return response(['success' => false, 'mess' => 'Промокод не найден или закончился' ]);
        }

       
        if (\Cache::has('user.promo.active.name.'.$name.'.'.$user->id)) {   
            return response(['success' => false, 'mess' =>  "Вы уже активировали этот код"]);
        }


        $active = \Cache::get('promo.name.'.$name.'.active');
        $actived = \Cache::get('promo.name.'.$name.'.active.count');
        $sum = \Cache::get('promo.name.'.$name.'.sum');

        if($actived == $active){
            return response(['success' => false, 'mess' => 'Промокод не найден или закончился' ]);
        }

       

        \Cache::put('user.promo.active.name.'.$name.'.'.$user->id, '1');

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }


        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Активация промокода',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $sum,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


        $lastbalance = $user->balance;
        $newbalance = $lastbalance + $sum;
        $user->balance += $sum;
        $user->save();
        $user->bonus_up = 1;
        
      
        \Cache::put('promo.name.'.$name.'.active.count', $actived + 1);


        return response(['success' => true, 'newbalance' => "{$newbalance}", 'lastbalance' => "{$lastbalance}"]);
    }

    public function transferGetUser(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}
        $id = $r->id;
        $user_count = User::where('id', $id)->count();
        if($user_count == 0){
            return response(['success' => false, 'mess' => 'Перевод данному пользователю невозможен' ]);
        }
        $user = User::where('id', $id)->first();
        if($user->admin == 1){
            return response(['success' => false, 'mess' => 'Перевод данному пользователю невозможен' ]);
        }

        if($user->id == \Auth::user()->id){
            return response(['success' => false, 'mess' => 'Перевод себе же невозможен' ]);
        }

        $avatar = $user->avatar;
        return response(['success' => true, 'avatar' => $avatar, 'id' => $id ]);
    }

    public function promoCreate(Request $r){
        $name = $r->name;
        $sum = $r->sum;
        $act = round($r->act);
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}


        if($sum < 1){
            return response(['success' => false, 'mess' => 'Сумма промокода меньше 1' ]);
        }

        if($act < 1){
            return response(['success' => false, 'mess' => 'Активаций меньше 1' ]);
        }

        if($name == ''){
            return response(['success' => false, 'mess' => 'Введите название промокода' ]);
        }

        if (\Cache::has('promo.name.'.$name)){
            return response(['success' => false, 'mess' => 'Такой промокод уже существует' ]);
        }

     

        $sum_pay = $act * $sum;
        $user = \Auth::user();
        if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }

        $setting = Setting::first();

        $dep_createpromo = $setting->dep_createpromo;
        
        if($user->deps < $dep_createpromo){
            return response(['success' => false, 'mess' => 'Сумма пополнений должна быть больше чем '.$dep_createpromo ]);
        }

        if($user->balance < $sum_pay){
            return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
        }

       

        $promocode = Promo::create(array(
            'name' => $name,
            'sum' => $sum,
            'active' => $act,
            'user_id' => $user->id,
            'user_name' => $user->name
        ));

        \Cache::put('promo.name.'.$name, '1');
        \Cache::put('promo.name.'.$name.'.active', $act);
        \Cache::put('promo.name.'.$name.'.active.count', 0);
        \Cache::put('promo.name.'.$name.'.sum', $sum);


        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Создание промокода',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance - $sum_pay,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $lastbalance = $user->balance;
        $newbalance = $lastbalance - $sum_pay;
        $user->balance -= $sum_pay;
        $user->save();

        return response(['success' => true, 'newbalance' => "{$newbalance}", 'lastbalance' => "{$lastbalance}"]);

    }

    public function transferGo(Request $r){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $id = $r->id;
        $sum = $r->sum;
        $setting = Setting::first();

        $dep_transfer = $setting->dep_transfer;


        $user = User::where('id', $id)->first();

        $my_user = \Auth::user();
        if($my_user->balance < $sum){
            return response(['success' => false, 'mess' => 'Недостаточно средств' ]);
        }
        if($sum < 1){
            return response(['success' => false, 'mess' => 'Сумма меньше 1' ]);
        }
        if($my_user->deps < $dep_transfer){
            return response(['success' => false, 'mess' => 'Сумма пополнений должна быть больше чем '.$dep_transfer ]);
        }

        if(!(\Cache::has('user.'.$my_user->id.'.historyBalance'))){ \Cache::put('user.'.$my_user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Перевод средств '.$user->name,
            'balance_before' => $my_user->balance,
            'balance_after' => $my_user->balance - $sum,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$my_user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
 $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$my_user->id.'.historyBalance', $cashe_hist_user);



        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Получение перевода от '.$my_user->name,
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $sum,
            'date' => date('d.m.Y H:i')
        );

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }
        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');
       $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);



        $lastbalance = $my_user->balance;
        $newbalance = $lastbalance - $sum;

        $my_user->balance -= $sum;
        $user->balance += $sum;
        $my_user->save();
        $user->save();

        return response(['success' => true, 'newbalance' => "{$newbalance}", 'lastbalance' => "{$lastbalance}"]);
    }

    public function getHistory(Request $r){
        $type = $r->type;
        $user = \Auth::user();
        if($type == 'deps'){
            $history = Payment::where('user_id', $user->id)->orderBy('id', 'desc')->take(20)->get();
        }else{
            $history = Withdraw::where('user_id', $user->id)->orderBy('id', 'desc')->take(20)->get();   
        }

        return response(['success' => true, 'history' => $history ]);
    }

    public function balanceGet(){
        $user = \Auth::user();
        return response(['success' => true, 'balance' => $user->balance ]);
    }
    public function bonusRef(){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        $refs = $user->bonus_refs;
        if ($refs < 10){ return response(['success' => false, 'mess' => 'У вас меньше 10 рефералов' ]);}
        
        $setting = Setting::first();

        $bonuses = [1, 3, 5, 8, 10, 15, 25, 50];
        $rand_b = rand(0, 5);
        $rand = $bonuses[$rand_b];

        // $rotate = 360 / 8 * $rand_b + (360 * 3);
        $rotate = 360 / 8 * (count($bonuses) - $rand_b) + (360 * 3);
        
        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Реф бонус',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $rand,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


        $newbalance = $user->balance + $rand;
        $lastbalance = $user->balance;
        $user->balance += $rand;
        $user->bonus_refs -= 10;
        
        $user->save();

        return response(['success' => true, 'mess' => "Получено {$rand}", 'newbalance' => "{$newbalance}", 'rotate' => "{$rotate}", 'lastbalance' => "{$lastbalance}", 'refs' => ($refs - 10) ]);
    }
    public function bonusCheckTg()
    {
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        $bonus_2 = $user->bonus_2;
        if ($bonus_2 != 2){ return response(['success' => false, 'mess' => 'Ваш аккаунт не привязан' ]);}
        return response(['success' => true, 'mess' => 'Теперь вы можете получить бонус' ]);
    }
    public function bonusGetTg(Request $request){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();

if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }

        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        $bonus_2 = $user->bonus_2;
        if ($bonus_2 == 1){ return response(['success' => false, 'mess' => 'Вы уже получали бонус' ]);}
        if ($bonus_2 == 0){ return response(['success' => false, 'mess' => 'Привяжите свой аккаунт TG', 'modal' => 'tg' ]);}
        $setting = Setting::first();

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'ТГ бонус',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $setting->bonus_group,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


        $lastbalance = $user->balance;
        $newbalance = $user->balance + $setting->bonus_group;

        $user->bonus_up = 1;
        $user->balance += $setting->bonus_group;
        $user->bonus_2 = 1;
        $user->save();

        return response(['success' => true, 'mess' => "Бонус успешно получен", 'newbalance' => "{$newbalance}", 'lastbalance' => "{$lastbalance}"]);

    }

    public static function isMessages($id) {
        $setting = Setting::first();
        $grid = $setting->group_id;
        $grtok = $setting->group_token;

        $count = 0;
        try {
            $i = 0;
            $arr = json_decode(file_get_contents("https://api.vk.com/method/messages.getHistory?access_token=". $grtok ."&group_id=". $grid ."&user_id=". $id . "&v=5.103"), true);
            return isset($arr['error']) ? false : ($arr['response']['count'] == 0 ? false : true);
            //foreach($arr['response']['items'] as $item) {
             //   $has = ($item['text'] == "+" ? true : false);
           // }

            //return $has;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function bonusGetVk(Request $request){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        $bonus_1 = $user->bonus_1;
        if ($bonus_1 == 1){ return response(['success' => false, 'mess' => 'Вы уже получали бонус' ]);}

        $setting = Setting::first();
        $grid = $setting->group_id;
        $grtok = $setting->group_token;

        $domainvk = $user->vk_id;

        $vk1 = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$domainvk}&access_token=".$grtok."&v=5.131"));
        $vk1 = $vk1->response[0]->id ?? 0;

        if($vk1 == 0){
            return response(['success' => false, 'mess' => "Ошибка №VK" ]);
        }
        $resp = file_get_contents("https://api.vk.com/method/groups.isMember?group_id=".$grid."&user_id={$vk1}&access_token=".$grtok."&v=5.131");
        $data = json_decode($resp, true);
        if($data['response'] != '1'){ return response(['success' => false, 'link' => $setting->group_link, 'mess' => 'Подпишитесь на нашу группу!' ]);}
        if(!$this->isMessages($user->vk_id)) return response()->json(['success' => false, 'mess' => 'Напишите "+" в личные сообщения группы']);

        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Вк бонус',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $setting->bonus_group,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);
        $user->bonus_up = 1;
        $newbalance = $user->balance + $setting->bonus_group;
        $lastbalance = $user->balance;
        $user->balance += $setting->bonus_group;
        $user->bonus_1 = 1;
        $user->save();

        return response(['success' => true, 'mess' => "Бонус успешно получен", 'newbalance' => "{$newbalance}", 'lastbalance' => "{$lastbalance}"]);


    }
    public function bonusGet(Request $request){
        if(\Auth::guest()){return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);}

        $user = \Auth::user();
if($user->type_balance == 1){
            return response(['success' => false, 'mess' => 'Переключитесь на реальный баланс']);
        }
        if(\Cache::has('action.user.' . $user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
        \Cache::put('action.user.' . $user->id, '', 1);

        if(!$this->isMessages($user->vk_id)) return response()->json(['success' => false, 'mess' => 'Напишите "+" в личные сообщения группы']);

        $user_deps = Payment::where('status', 1)->where('user_id', $user->id)->whereDate('created_at', '>', Carbon::now()->subDays(7))->sum('sum');

        if($user_deps < 0){
            return response(['success' => false, 'mess' => 'Для получения бонуса требуется минимальная сумма пополнений за 7 дней - 0р. (У вас '.$user_deps.'р)']);
        }


        $bdate = $user->bdate;
        $time = time();
        $f_time = $time - $bdate;
        $w_time = 43200 - $f_time;
        $seconds = $w_time; // Количество исходных секунд
        $minutes = floor($seconds / 60); // Считаем минуты
        $hours = floor($minutes / 60); // Считаем количество полных часов
        $minutes = $minutes - ($hours * 60);  // Считаем количество оставшихся минут
        $sec = $seconds % 60;
        if($sec < 10){ $sec = '0'.$sec; }
        if($hours < 10){ $hours = '0'.$hours; }
        if($minutes < 10){ $minutes = '0'.$minutes; }
        $w__time = $hours.':'.$minutes.':'.$sec; // Получаем время например - 12:34:56

        if($f_time < 43200){return response(['success' => false, 'mess' => "Ожидайте еще {$w__time}" ]);}

        $bonuses = [1, 3, 5, 8, 10, 15, 25, 50];
        $rand_b = rand(0, 2);
        $rand = $bonuses[$rand_b];

        $rotate = 360 / 8 * (count($bonuses) - $rand_b) + (360 * 3);
        
        if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

        $hist_balance = array(
            'user_id' => $user->id,
            'type' => 'Ежедневный бонус',
            'balance_before' => $user->balance,
            'balance_after' => $user->balance + $rand,
            'date' => date('d.m.Y H:i')
        );

        $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

        $cashe_hist_user = json_decode($cashe_hist_user);
        $cashe_hist_user[] = $hist_balance;
        $cashe_hist_user = json_encode($cashe_hist_user);
        \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);

        $user->bonus_up = 1;

        $newbalance = $user->balance + $rand;
        $lastbalance = $user->balance;
        $user->balance += $rand;
        $user->bdate = time();
        $user->save();

        return response(['success' => true, 'mess' => "Получено {$rand}", 'newbalance' => "{$newbalance}", 'rotate' => "{$rotate}", 'lastbalance' => "{$lastbalance}" ]);

    }


}
