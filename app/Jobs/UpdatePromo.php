<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Promo;
class UpdatePromo implements ShouldQueue
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
        $promo_id = $this->message['id'];
       
        $promo = Promo::where('id', $promo_id)->first();
        $name = $promo->name;

        if(!\Cache::has('promo.name.'.$name)){
            $promo->delete();
        }else{
            $active = \Cache::get('promo.name.'.$name.'.active');
            $actived = \Cache::get('promo.name.'.$name.'.active.count');

            if($active == $actived){
                \Cache::put('promo.name.'.$name, '', 0);
                $promo->delete();
            }else{
                $promo->actived = $actived;
                $promo->save();

                \App\Jobs\UpdatePromo::dispatch(['id' => $promo->id])->delay(now()->addMinutes(10));
            }
        }

        
    }
}
