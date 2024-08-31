<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Promo;
use App\User;
use App\Status;
use Illuminate\Support\Facades\Redis;
use Auth;

class ChatController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->redis = Redis::connection();
  }

  public function get(){
    $history = Message::orderBy('id','desc')->where('hidden', 0)->take(20)->get();

    return response(['success'=> true, 'history'=> $history]);
  }

  function smile($text) {
    return strtr($text,
      [    
        ':smile_1:' => '<img class="chat__msg-smile" src="images/chat/smiles/1.png">',
        ':smile_2:' => '<img class="chat__msg-smile" src="images/chat/smiles/2.png">',
        ':smile_3:' => '<img class="chat__msg-smile" src="images/chat/smiles/3.png">',
        ':smile_4:' => '<img class="chat__msg-smile" src="images/chat/smiles/4.png">',
        ':smile_5:' => '<img class="chat__msg-smile" src="images/chat/smiles/5.png">',
        ':smile_6:' => '<img class="chat__msg-smile" src="images/chat/smiles/6.png">',
        ':smile_7:' => '<img class="chat__msg-smile" src="images/chat/smiles/7.png">',
        ':smile_8:' => '<img class="chat__msg-smile" src="images/chat/smiles/8.png">',
        ':smile_9:' => '<img class="chat__msg-smile" src="images/chat/smiles/9.png">',
        ':smile_10:' => '<img class="chat__msg-smile" src="images/chat/smiles/10.png">',
        ':smile_11:' => '<img class="chat__msg-smile" src="images/chat/smiles/11.png">',
        ':smile_12:' => '<img class="chat__msg-smile" src="images/chat/smiles/12.png">',
        ':smile_13:' => '<img class="chat__msg-smile" src="images/chat/smiles/13.png">',
        ':smile_14:' => '<img class="chat__msg-smile" src="images/chat/smiles/14.png">',
        ':smile_15:' => '<img class="chat__msg-smile" src="images/chat/smiles/15.png">',
        ':smile_16:' => '<img class="chat__msg-smile" src="images/chat/smiles/16.png">',
        ':smile_17:' => '<img class="chat__msg-smile" src="images/chat/smiles/17.png">',
        ':smile_18:' => '<img class="chat__msg-smile" src="images/chat/smiles/18.png">',
        ':smile_19:' => '<img class="chat__msg-smile" src="images/chat/smiles/19.png">',
        ':smile_20:' => '<img class="chat__msg-smile" src="images/chat/smiles/20.png">',
        ':smile_21:' => '<img class="chat__msg-smile" src="images/chat/smiles/21.png">',
        ':smile_22:' => '<img class="chat__msg-smile" src="images/chat/smiles/22.png">',
        ':smile_23:' => '<img class="chat__msg-smile" src="images/chat/smiles/23.png">',
        ':smile_24:' => '<img class="chat__msg-smile" src="images/chat/smiles/24.png">',
        ':smile_25:' => '<img class="chat__msg-smile" src="images/chat/smiles/25.png">',
        ':smile_26:' => '<img class="chat__msg-smile" src="images/chat/smiles/26.png">',
        ':smile_27:' => '<img class="chat__msg-smile" src="images/chat/smiles/27.png">',
        ':smile_28:' => '<img class="chat__msg-smile" src="images/chat/smiles/28.png">',
        ':smile_29:' => '<img class="chat__msg-smile" src="images/chat/smiles/29.png">',
        ':smile_30:' => '<img class="chat__msg-smile" src="images/chat/smiles/30.png">',
        ':smile_31:' => '<img class="chat__msg-smile" src="images/chat/smiles/31.png">',
        ':smile_32:' => '<img class="chat__msg-smile" src="images/chat/smiles/32.png">',
        ':smile_33:' => '<img class="chat__msg-smile" src="images/chat/smiles/33.png">',
        ':smile_34:' => '<img class="chat__msg-smile" src="images/chat/smiles/34.png">',
        ':smile_35:' => '<img class="chat__msg-smile" src="images/chat/smiles/35.png">',
        ':smile_36:' => '<img class="chat__msg-smile" src="images/chat/smiles/36.png">',
        ':smile_37:' => '<img class="chat__msg-smile" src="images/chat/smiles/37.png">',
        ':smile_38:' => '<img class="chat__msg-smile" src="images/chat/smiles/38.png">',
        ':smile_39:' => '<img class="chat__msg-smile" src="images/chat/smiles/39.png">',
        ':smile_40:' => '<img class="chat__msg-smile" src="images/chat/smiles/40.png">',
        ':smile_41:' => '<img class="chat__msg-smile" src="images/chat/smiles/41.png">',
        ':smile_42:' => '<img class="chat__msg-smile" src="images/chat/smiles/42.png">',
        ':smile_43:' => '<img class="chat__msg-smile" src="images/chat/smiles/43.png">',
        ':smile_44:' => '<img class="chat__msg-smile" src="images/chat/smiles/44.png">',
        ':smile_45:' => '<img class="chat__msg-smile" src="images/chat/smiles/45.png">',
        ':smile_46:' => '<img class="chat__msg-smile" src="images/chat/smiles/46.png">',
        ':smile_47:' => '<img class="chat__msg-smile" src="images/chat/smiles/47.png">',
        ':smile_48:' => '<img class="chat__msg-smile" src="images/chat/smiles/48.png">',
        ':smile_49:' => '<img class="chat__msg-smile" src="images/chat/smiles/49.png">',
        ':smile_50:' => '<img class="chat__msg-smile" src="images/chat/smiles/50.png">',
        ':smile_51:' => '<img class="chat__msg-smile" src="images/chat/smiles/51.png">',
        ':smile_52:' => '<img class="chat__msg-smile" src="images/chat/smiles/52.png">',
        ':smile_53:' => '<img class="chat__msg-smile" src="images/chat/smiles/53.png">',
        ':smile_54:' => '<img class="chat__msg-smile" src="images/chat/smiles/54.png">',
        ':smile_55:' => '<img class="chat__msg-smile" src="images/chat/smiles/55.png">',
        ':smile_56:' => '<img class="chat__msg-smile" src="images/chat/smiles/56.png">',
        ':smile_57:' => '<img class="chat__msg-smile" src="images/chat/smiles/57.png">',
        ':smile_58:' => '<img class="chat__msg-smile" src="images/chat/smiles/58.png">',
        ':smile_59:' => '<img class="chat__msg-smile" src="images/chat/smiles/59.png">'
      ]
    );
  }

  public function delete(Request $r){
    $id = $r->id;

    if($this->user->admin == 0) return response(['success' => false, 'mess' => 'Ошибка']);

    Message::where('id', $id)->update(['hidden' => 1]);

    $this->redis->publish('mess', json_encode(['type' => 'deleteMess', 'id' => $id]));
    return response(['success' => true]);
  }

  public function ban(Request $r){
    $id = $r->id;
    $time_ban = $r->time_ban;
    $why_ban = $r->why_ban;

    if($this->user->admin == 0) return response(['success'=> false, 'mess' => 'Ошибка']);
    if($why_ban == 0) return response(['success' => false, 'mess' => 'Укажите причину бана']);
   
    $m = Message::where('id', $id)->first();
    $user_id = $m->user_id;
    $info_user = User::where('id', $user_id)->first();
    $admin = $info_user->admin;
    $chat_ban = $info_user->chat_ban;
    $time_chat_ban = $info_user->time_chat_ban;
    $name = $info_user->name;
    $count_chat_ban = $info_user->count_chat_ban;
    $now = time();

    if($time_chat_ban > $now) return response(['success'=>false,'mess'=>'Пользователь уже забанен']);
    if($chat_ban == 1) return response(['success'=>false,'mess'=>'Пользователь уже забанен']);
    if($admin != 0) return response(['success'=>false,'mess'=>'Ошибка']);
    if($this->user->id == $user_id) return response(['success'=>false,'mess'=>'Ошибка']);

    $mess = Message::where('id', $id)->select('autor')->first();
    $autor = $mess->autor;

    $this->redis->publish('mess', json_encode(['type' => 'deleteMess', 'id' => $id]));
    
    if($time_ban == '') {
      $info_user->chat_ban = 1;
      $info_user->save();
      $date_ban_do = 'навсегда';
    } else {
      $date_sec = strtotime($time_ban);

      $info_user->time_chat_ban = $date_sec;
      $info_user->save();
        
      $date_ban_do = date('до d.m H:i', $date_sec);
    }
    
    $w_w = ["попрошайничество", "распространение реф кодов", "оскорбление", "спам", "слив промо", "пиар", "клевета", "введение в заблуждение"];


    $message = Message::create([
      'content'  => "Пользователь ".$name." был заблокирован в чате ".$date_ban_do.". \n Причина: ".$w_w[$why_ban - 1],
      'type_mess' => 4,
      'autor' => '<span style="color:#7001b2;">СИСТЕМА</span>',
      'avatar' => "../img/ava_c.png",
      'user_id' => $this->user->id,
      'status_mess' => '',
      'time' => date('H:i')
    ]);


    $callback = [
      'id' => $message->id,
      'type_mess' => 4,
      'status_mess' => '',
      'time' => date('H:i'),
      'success' => "success",
      'content'  => "Пользователь ".$name." был заблокирован в чате ".$date_ban_do.". \n Причина: ".$w_w[$why_ban - 1],
      'autor' => '<span style="color:#7001b2;">СИСТЕМА</span>',
      'avatar' => "../img/ava_c.png",
      'type' => "uploadMessage"
    ];

    Message::where('id', $id)->update(['hidden' => 1]);

    $this->redis->publish('mess', json_encode($callback));
    return response(['success' => 'success']);
  }

  public function promoPublish1(){
    $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $name = substr(str_shuffle($permitted_chars), 0, 4).'-'.substr(str_shuffle($permitted_chars), 0, 4).'-'.substr(str_shuffle($permitted_chars), 0, 4).'-'.substr(str_shuffle($permitted_chars), 0, 4);

    $promocode = Promo::create([
      'name' => $name,
      'sum' => 5,
      'active' => 20,
      'user_id' => 0,
      'user_name' => "Система"
    ]);

    \Cache::put('promo.name.'.$name, '1');
    \Cache::put('promo.name.'.$name.'.active', 20);
    \Cache::put('promo.name.'.$name.'.active.count', 0);
    \Cache::put('promo.name.'.$name.'.sum', 5);

    $message = Message::create([
      'content'  => $name,
      'type_mess' => 0,
      'autor' => '<span style="color:#e45151">Новый промокод</span>',
      'avatar' => "../img/ava_c.png",
      'user_id' => 0,
      'status_mess' => '',
      'time' => date('H:i')
    ]);
        
    $callback = [
      'id' => $message->id,
      'type_mess' => 0,
      'success' => "success",
      'content'  => $name,
      'autor' => '<span style="color:#e45151">Новый промокод</span>',
      'avatar' => "../img/ava_c.png",
      'type' => "uploadMessage",
      'status_mess' => '',
      'time' => date('H:i')
    ];

    $this->redis->publish('mess', json_encode($callback));
    return response(['success' => true, 'mess' => 'Успешно' ]);
  }

  public function sendSticker(Request $request){
    $sticker = $request->sticker;
    $stickers = range(1, 21);

    if(!in_array($sticker, $stickers)) return response(['success' => false, 'mess' => 'Ошибка']);
    if(Auth::guest()) return response(['success' => false, 'mess' => 'Авторизуйтесь' ]);

    if(\Cache::has('action.user.' . $this->user->id)) return response(['success' => false, 'mess' => 'Подождите 3 сек.']);
    \Cache::put('action.user.' . $this->user->id, '', 3);

    if($this->user->time_chat_ban > time()) return response(['success' => false, 'mess' => 'Вы заблокированы в чате до '. date("d.m.Y H:i", $this->user->time_chat_ban)]);
    if($this->user->chat_ban == 1){  return response(['success' => false, 'mess' => 'Вы заблокированы в чате навсегда' ]);}

    $name = $this->user->name;
    $admin = $this->user->admin;
    $ava = $this->user->avatar;
    $name_c = $this->user->name;
    $status_mess = $this->user->status;

    if($status_mess != 0) {
      $st = Status::where('id', $status_mess)->first();
      $color = $st->color;
      $name = $st->name;
      $class= $st->class;

      if($status_mess > 2) {
        $style = '#fff';
      } else { 
        $style = '#000';
      }

      $status_mess = '<span class="user-status '.$class.'">'.$name.'</span>';
    } else {
      $status_mess = '<span class="user-status new">Новичок</span>';
    }

    if($admin == 1){
      $ava = '../img/ava_c.png';
      $name_c = '<span style="color:#e45151">Администратор</span>';
      $status_mess = '';
    }

    if($admin == 2){
      $ava = '../img/ava_c.png';
      $name_c = '<span style="color:#33bf7c">Модератор</span>';
      $status_mess = '';
    }

    $message = Message::create([
      'content'  => "<img class='chat__msg-stickers' src='images/chat/stickers/".$sticker.".jpg'>",
      'type_mess' => $admin,
      'autor' => $name_c,
      'avatar' => $ava,
      'user_id' => $this->user->id,
      'status_mess' => $status_mess,
      'time' => date('H:i')
    ]);

    $callback = [
      'id' => $message->id,
      'type_mess' => $admin,
      'success' => "success",
      'content'  => "<img class='chat__msg-stickers' src='images/chat/stickers/".$sticker.".jpg'>",
      'autor' => $name_c,
      'avatar' => $ava,
      'type' => "uploadMessage",
      'status_mess' => $status_mess,
      'time' => date('H:i')
    ];

    $this->redis->publish('mess', json_encode($callback));
    return response(['success' => true, 'mess' => 'Успешно']);
  }

  public function postMessage(Request $request){

    $mess = htmlentities($request->message, ENT_QUOTES, 'UTF-8');

    if(Auth::guest()) return response(['success' => false, 'mess' => 'Авторизуйтесь']);

    if(\Cache::has('chat.user.' . $this->user->id)) return response(['success' => false, 'mess' => 'Подождите перед предыдущим действием!' ]);
    \Cache::put('chat.user.' . $this->user->id, '', 2);

    if($this->user->time_chat_ban /* <= */ > time()) return response(['success' => false, 'mess' => 'Вы заблокированы в чате до '. date("d.m.Y H:i", $this->user->time_chat_ban)]);
    if($this->user->chat_ban == 1) return response(['success' => false, 'mess' => 'Вы заблокированы в чате навсегда' ]);
    if(!trim($mess)) return response(['success' => false, 'mess' => 'Введите сообщение' ]);
    if(strlen($mess) > 150) return response(['success' => false, 'mess' => 'Длина сообщения больше 150']);
    if(preg_match("/href|url|http|https|www|.ru|.com|.net|.info|csgo|winner|ru|xyz|com|net|space|site|fun|top|run|info|.org/i", $mess)) return response(['success' => false, 'mess' => 'Ссылки запрещены' ]);
    if(preg_match("/href|.org/i", $mess)) return response(['success' => false, 'mess' => 'Промокоды запрещены' ]);

    function object_to_array($data) {
      if (is_array($data) || is_object($data)) {
        $result = [];
        foreach ($data as $key => $value) {
          $result[$key] = object_to_array($value);
        }
        return $result;
      }
      return $data;
    }

    $words = file_get_contents(dirname(__FILE__) . '/words.json');
    $words = object_to_array(json_decode($words));

    if($this->user->admin != 1 && $this->user->admin != 2){
      foreach ($words as $key => $value) {
        $mess = str_ireplace($key, $value, $mess);
      }
    }

    if($this->user->admin == 1 || $this->user->admin == 2){
      if($mess == '/clear'){
        Message::truncate();

        $this->redis->publish('mess', json_encode(['type' => "chat_clear"]));
        return response(['success' => true, 'mess' => 'Успешно' ]);
      }
    }

    $ava = $this->user->avatar;
    $name_c = $this->user->name;
    $status_mess = $this->user->status;

    if($status_mess != 0) {
      $st = Status::where('id', $status_mess)->first();
      $color = $st->color;
      $name = $st->name;
      $class= $st->class;

      if($status_mess > 2) {
        $style = '#fff';
      } else { 
        $style = '#000';
      }

      $status_mess = '<span class="user-status '.$class.'">'.$name.'</span>';
    } else {
      $status_mess = '<span class="user-status new">Новичок</span>';
    }

    if($this->user->admin == 1) {
      $ava = '../img/ava_c.png';
      $name_c = '<span style="color:#e45151">Администратор</span>';
      $status_mess = '';
    }

    if($this->user->admin == 2) {
      $ava = '../img/ava_c.png';
      $name_c = '<span style="color:#33bf7c">Модератор</span>';
      $status_mess = '';
    }

    if($this->user->admin == 3) {
      $status_mess = '<span class="user-status vip" style="color: blue">Ютубер</span>';
    }

    $mess = $this->smile($mess);

    $message = Message::create([
      'content'  => $mess,
      'type_mess' => $this->user->admin,
      'autor' => $name_c,
      'avatar' => $ava,
      'user_id' => $this->user->id,
      'status_mess' => $status_mess,
      'time' => date('H:i')
    ]);


    $callback = [
      'id' => $message->id,
      'type_mess' => $this->user->admin,
      'success' => "success",
      'content'  => $mess,
      'autor' => $name_c,
      'avatar' => $ava,
      'type' => "uploadMessage",
      'status_mess' => $status_mess,
      'time' => date('H:i')
    ];

    $this->redis->publish('mess', json_encode($callback));
    return response(['success' => true, 'mess' => 'Успешно']);
  }
}