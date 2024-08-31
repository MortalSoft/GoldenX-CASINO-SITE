<?php


namespace App\Classes;


use Illuminate\Support\Facades\Log;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;
use App\User;
use App\Repost;
use App\UserRepost;
use App\Posts;
class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = 'blupper_secret123';
    const GROUP_ID = 219569549;
    const CONFIRMATION_TOKEN = 'e16b5ce7';

    protected $chatId;
    protected $text;

    function confirmation(int $group_id, ?string $secret)
    {
        Log::info(print_r($group_id, true));
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function wallPostNew(int $group_id, ?string $secret, array $object)
    {
        
        $postId = $object["id"];
        $postType = $object["post_type"];

        if($postType == 'post'){
            $this->sendMessage(451073906, "Новый пост в группе");
            Posts::create(array(
                'post_id' => $postId
            ));
        }

        echo 'ok';
    }
    public function wallRepost(int $group_id, ?string $secret, array $object)
    {        

        $this->userId = $object["from_id"];
        $this->postId = $object["copy_history"][0]->id;

        $user = User::where('vk_id', $this->userId)->first();
        $user_repost = UserRepost::where('post_id', $this->postId)->where('user_id', $user->id)->count();

        $posts_min_id = Posts::max('id') - 25;
        if($posts_min_id < 0){
            $posts_min_id = 1;
        }
        $posts = Posts::where('post_id', $this->postId)->count();
        if($posts == 0){
            $user_repost = 1;
        }else{
            $post = Posts::where('post_id', $this->postId)->first();
            if($post->id < $posts_min_id){
                $user_repost = 1;
            }
        }
        if($user_repost == 0){
        	UserRepost::create(array(
        		'user_id' => $user->id,
        		'post_id' => $this->postId
        	));
            // далее 10 100 200
            $reposts = $user->reposts;
            $balance_repost = $user->balance_repost;

            $newreposts = $reposts + 1;
            $count_repost_level = Repost::where('repost_from', '<=', $newreposts)->where('repost_to', '>=', $newreposts)->count();
            if($count_repost_level == 0){
                $repost_level = Repost::orderBy('id', 'desc')->first();
            }else{
                $repost_level = Repost::where('repost_from', '<=', $newreposts)->where('repost_to', '>=', $newreposts)->first();
            }

           
            $bonus = $repost_level->bonus;
           
           

            $new_balance_repost = $balance_repost + $bonus;

            $user->reposts = $newreposts;
            $user->balance_repost = $new_balance_repost;
            $user->save();

            $this->sendMessage(451073906, "Новый репост #".$this->postId."! От @id".$this->userId," (@id".$this->userId.")");
        }
        

         echo 'ok';
    }

    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        Log::info(print_r($object, true));


        $this->chatId = $object["peer_id"];
        $this->text = $object["text"];

        $arr = [
            [
                "key" => "привет",
                "func" => function () {
                    $this->sendMessage($this->chatId, "Привет, Друг!");
                },
            ],
            [
                "key" => "как дела",
                "func" => function () {
                    $this->sendMessage($this->chatId, "Норм, а у тебя?");
                    },
            ],

            [
                "key" => "хай",
                "func" => function () {
                    $this->sendMessage($this->chatId, "Нихао!");
                },
            ]

        ];

        $is_found = false;
        foreach ($arr as $item) {

            $tmp = mb_strtolower($this->text);

            Log::info("$tmp =>");
            if (strpos($tmp, $item["key"]) !==false) {
                $item["func"]();
                $is_found = true;
                //break;
            }
        }

        if (!$is_found)
            //$this->sendMessageWithKeyboard($this->chatId, "Я тебя не понимаю!(");

        //$this->sendMessageWithKeyboard($this->chatId,"Спасибо! Ваше сообщение: $this->text ");
        echo 'ok';
    }

    protected function sendMessage($chatId, $message)
    {
        $access_token = 'vk1.a.oy5FrvTv4CI0sgjvZwBhGNwwcBwAeT7-QdVDOQjSjj4MZua13LHagd0iJETbcZDMOP8u7TaWCs9b_6uYmugxhye7qJUWIrCmkkf0uWwedsw9j6JJRQW9gbOLRdCB_-R0R-Pju8bSXtyeHm4wygb71tWHRtV9rx_UFExWu_o1u5YrXHYemuzkl_87Xd4Bdt5gxwOSc8xtX0RqOlpV4cdhmg';
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),

        ]);
    }

    protected function sendMessageWithKeyboard($chatId, $message)
    {
        $access_token = 'vk1.a.oy5FrvTv4CI0sgjvZwBhGNwwcBwAeT7-QdVDOQjSjj4MZua13LHagd0iJETbcZDMOP8u7TaWCs9b_6uYmugxhye7qJUWIrCmkkf0uWwedsw9j6JJRQW9gbOLRdCB_-R0R-Pju8bSXtyeHm4wygb71tWHRtV9rx_UFExWu_o1u5YrXHYemuzkl_87Xd4Bdt5gxwOSc8xtX0RqOlpV4cdhmg';
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),
            'keyboard' => json_encode([
                "one_time"=>false,
                "buttons"=>[
                    [
                        [
                            "action"=>[
                                "type"=>"text",
                                "payload"=>"{\"button\":\"привет\"}",
                                "label"=>"Привет!"
                            ],
                            "color"=>"positive"
                        ],

                        [
                            "action"=>[
                                "type"=>"text",
                                "payload"=>"{\"button\":\"прощай\"}",
                                "label"=>"Прощай!"
                            ],
                            "color"=>"negative"
                        ]
                    ],[
                        [
                            "action"=>[
                                "type"=>"text",
                                "payload"=>"{\"button\":\"как дела\"}",
                                "label"=>"Как дела!"
                            ],
                            "color"=>"secondary"
                        ],
                    ]
                ]
            ])

        ]);
    }
}