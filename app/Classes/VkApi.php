<?php

namespace App\Classes;
class VkApi{
    /**
     * Токен
     * @var string
     */
    private $token = '1797d47316809b83b48e5e3237f3fed22e7d5d8f302283b473adeb83ecb4d6c849d23e850a91ead6d9cd8';
    private $v = '';
    /**
     * @param string $token Токен
     */
    public function __construct($token, $v){
        $this->token = $token;
        $this->v = $v;
    }
    /**
     * Отправить сообщение пользователю
     * @param int $sendID Идентификатор получателя
     * @param string $message Сообщение
     * @return mixed|null
     */
    public function sendDocMessage($sendID, $id_owner, $id_doc){
        if ($sendID != 0 and $sendID != '0') {
            return $this->request('messages.send',array('attachment'=>"doc". $id_owner . "_" . $id_doc,'user_id'=>$sendID));
        } else {
            return true;
        }
    }

    public function sendMessage($sendID,$message){
        if ($sendID != 0 and $sendID != '0') {
            return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID));
        } else {
            return true;
        }
    }

    public function sendOK(){
        echo 'ok';
        $response_length = ob_get_length();
        // check if fastcgi_finish_request is callable
        if (is_callable('fastcgi_finish_request')) {
            /*
             * This works in Nginx but the next approach not
             */
            session_write_close();
            fastcgi_finish_request();

            return;
        }

        ignore_user_abort(true);

        ob_start();
        $serverProtocole = filter_input(INPUT_SERVER, 'SERVER_PROTOCOL', FILTER_SANITIZE_STRING);
        header($serverProtocole.' 200 OK');
        header('Content-Encoding: none');
        header('Content-Length: '. $response_length);
        header('Connection: close');

        ob_end_flush();
        ob_flush();
        flush();
    }

    public function sendButton($sendID, $message, $gl_massiv = [], $one_time = False) {
        $buttons = [];
        $i = 0;
        foreach ($gl_massiv as $button_str) {
            $j = 0;
            foreach ($button_str as $button) {
                $color = $this->replaceColor($button[2]);
                $buttons[$i][$j]["action"]["type"] = "text";
                if ($button[0] != null)
                    $buttons[$i][$j]["action"]["payload"] = json_encode($button[0], JSON_UNESCAPED_UNICODE);
                $buttons[$i][$j]["action"]["label"] = $button[1];
                $buttons[$i][$j]["color"] = $color;
                $j++;
            }
            $i++;
        }
        $buttons = array(
            "one_time" => $one_time,
            "buttons" => $buttons);
        $buttons = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        //echo $buttons;
        return $this->request('messages.send',array('message'=>$message, 'peer_id'=>$sendID, 'keyboard'=>$buttons));
    }

    public function sendDocuments($sendID, $selector = 'doc'){
        if ($selector == 'doc')
            return $this->request('docs.getMessagesUploadServer',array('type'=>'doc','peer_id'=>$sendID));
        else
            return $this->request('photos.getMessagesUploadServer',array('peer_id'=>$sendID));
    }

    public function saveDocuments($file, $titile){
        return $this->request('docs.save',array('file'=>$file, 'title'=>$titile));
    }

    public function savePhoto($photo, $server, $hash){
        return $this->request('photos.saveMessagesPhoto',array('photo'=>$photo, 'server'=>$server, 'hash' => $hash));
    }

    /**
     * Запрос к VK
     * @param string $method Метод
     * @param array $params Параметры
     * @return mixed|null
     */
    public function request($method,$params=array()){
        $url = 'https://api.vk.com/method/'.$method;
        $params['access_token']=$this->token;
        $params['v']=$this->v;
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type:multipart/form-data"
            ));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            $result = json_decode(curl_exec($ch), True);
            curl_close($ch);
        } else {
            $result = json_decode(file_get_contents($url, true, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'content' => http_build_query($params)
                )
            ))), true);
        }
        if (isset($result['response']))
            return $result['response'];
        else
            return $result;
    }

    private function replaceColor($color) {
        switch ($color) {
            case 'red':
                $color = 'negative';
                break;
            case 'green':
                $color = 'positive';
                break;
            case 'white':
                $color = 'default';
                break;
            case 'blue':
                $color = 'primary';
                break;

            default:
                # code...
                break;
        }
        return $color;
    }

    private function sendFiles($url, $local_file_path, $type = 'file') {
        $post_fields = array(
            $type => new CURLFile(realpath($local_file_path))
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $output = curl_exec($ch);
        return $output;
    }

    public function sendImage($id, $local_file_path)
    {
        $upload_url = $this->sendDocuments($id, 'photo')['upload_url'];

        $answer_vk = json_decode($this->sendFiles($upload_url, $local_file_path, 'photo'), true);

        $upload_file = $this->savePhoto($answer_vk['photo'], $answer_vk['server'], $answer_vk['hash']);

        $this->request('messages.send', array('attachment' => "photo" . $upload_file[0]['owner_id'] . "_" . $upload_file[0]['id'], 'peer_id' => $id));

        return 1;
    }
}
