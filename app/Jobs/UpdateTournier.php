<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Tourniers;
use App\TournierTable;
use VK\Client\VKApiClient;
use App\User;

class UpdateTournier implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->message = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */ 
    public function handle()
    {   
        $tournier_id = $this->message['id'];
        $tournier_type = $this->message['type'];
        
        $tournier = Tourniers::where('id', $tournier_id)->first();

        if($tournier->game_id == 1){
            $photo_start = 'photo670021108_457241760';
            $photo_end = 'photo670021108_457241685';
        }else{
            $photo_start = 'photo670021108_457242087';
            $photo_end = 'photo670021108_457242090';
        }

        if($tournier_type == 1){
            $end = date("d.m.Y в H:i", $tournier->end);

            $vk = new VKApiClient();
            $access_token = '886334e2c8a0b7a41017c7acb00d5efdf063063dd5317a1e407e302ef0a0a98c1fbd4c7d2574260ae1744';
            
            

            $response = $vk->wall()->post($access_token, array(
                'owner_id' => -206394471,
                'message' => "&#128165; Начался турнир по режиму ".$tournier->game.". Чем больше сумма общих выигрышей у вас будет на момент конца турнира, тем выше будет ваш приз. \n\n &#9851; Призовой фонд - ".$tournier->prize."р \n &#9851; Призовых мест - ".$tournier->places." \n &#9851; Конец - ".$end."",
                'attachments' => $photo_start
            ));

            $tournier->status = 1;
            $tournier->save();
        }

        if($tournier_type == 2){
            $tourniertable = TournierTable::where('tournier_id', $tournier->id)->orderBy('scores', 'desc')->limit($tournier->places)->get();

            $count_t = 0;
            $prizes = json_decode($tournier->prizes);

            $text = "";

            foreach ($tourniertable as $t) {
                $user = User::where('id', $t->user_id)->first();

                $score = $t->scores;
                $prize = $prizes[$count_t];

                $text .= "&#129472; @id".$user->vk_id." (".$user->name.") - ".$prize."р. Набрал ".$score." очков \n";
                $count_t += 1;

                $userBalance = $user->balance;

                $user->balance += $prize;
                $user->save();


                if(!(\Cache::has('user.'.$user->id.'.historyBalance'))){ \Cache::put('user.'.$user->id.'.historyBalance', '[]'); }

                $hist_balance = array(
                    'user_id' => $user->id,
                    'type' => "Выигрыш в турнире",
                    'balance_before' => $userBalance,
                    'balance_after' => $userBalance + $prize,
                    'date' => date('d.m.Y H:i:s')
                );

                $cashe_hist_user = \Cache::get('user.'.$user->id.'.historyBalance');

                $cashe_hist_user = json_decode($cashe_hist_user);
                $cashe_hist_user[] = $hist_balance;
                $cashe_hist_user = json_encode($cashe_hist_user);
                \Cache::put('user.'.$user->id.'.historyBalance', $cashe_hist_user);


            }

            $vk = new VKApiClient();
            $access_token = '886334e2c8a0b7a41017c7acb00d5efdf063063dd5317a1e407e302ef0a0a98c1fbd4c7d2574260ae1744';
            
            $response = $vk->wall()->post($access_token, array(
                'owner_id' => -206394471,
                'message' => "&#128165; Турнир по режиму ".$tournier->game." закончился. \n\n &#9851; Победители: \n ".$text."",
                'attachments' => $photo_end
            ));

            TournierTable::where('tournier_id', $tournier->id)->delete();
            // $tournier->status = 0;
            $tournier->delete();
        }

        
    }
}
