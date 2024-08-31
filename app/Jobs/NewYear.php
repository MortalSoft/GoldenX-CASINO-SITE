<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Redis;
use App\Setting;

class NewYear implements ShouldQueue
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
        $callback = [
            'type'=>'NewYear'
        ];

        $redis = Redis::connection();
        
        $redis->publish('openNewYear', json_encode($callback));

        $setting = Setting::first();
        $setting->newYear = 1;
        $setting->save();

        \App\Jobs\CloseNewYear::dispatch(['type' => ''])->delay(now()->addMinutes(10));
        
    }
}
