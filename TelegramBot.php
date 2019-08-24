<?php
include ('Model.php');
class TelegramBot
{
    protected $token = '914220148:AAHznTbsXetdo8vXtnSocEY4VJy8L39CWyg';
    protected $updateId;
    protected $userTable = 'bot_admin';

    //Car variables;
    public $carNumber;
    //Database
    protected $db;

    protected function query($method, $params= [])
    {
        // https://api.telegram.org/bot914220148:AAHznTbsXetdo8vXtnSocEY4VJy8L39CWyg/getMe
        $url = 'https://api.telegram.org/bot';
        $url .= $this->token;
        $url .= '/' . $method;
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        $client = new \GuzzleHttp\Client([
            'base_uri' => $url
        ]);

        $result = $client->request('GET');

        return json_decode($result->getBody());
    }
    public function getUpdates()
    {
        $response = $this->query('getUpdates', [
            'offset' => $this->updateId + 1
        ]);
        // var_dump('die');die;
        if (!empty($response->result)){
            $this->updateId = $response->result[count($response->result)-1]->update_id;
        }

        return $response->result;
    }

    public function getFile($file_id){
        $response = $this->query('getFile',[
            'file_id' => $file_id
        ]);
        $relativeFilePath = $response->result->file_path;

        $url = 'https://api.telegram.org';
        $url .= '/file';
        $url .= '/bot'.$this->token;
        $url .= '/' . $relativeFilePath;

        return $url;
        //https://api.telegram.org/file/bot<token>/<file_path>
    }
    public function sendMessage($chat_id, $text)
    {
        $response = $this->query('sendMessage', [
           'text' => $text,
            'chat_id' => $chat_id
        ]);
        return $response;
    }
    public function sendPhoto($chat_id)
    {
       //$img = curl_file_create('img/logo.gif','image/gif');
        $response = $this->query('sendPhoto', [
       //    'text' => $text,
            'chat_id' => $chat_id ,
            'photo' => 'http://www.dorfman.lv/dor_disign/logo_dorfmanaserviss.gif'
        ]);
        return $response;
    }
    public function sendMessageKeyboard($chat_id, array $keyboard)
    {
        $keyboard = array($keyboard);
        $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
        $reply = json_encode($resp);

        $response = $this->query('sendMessage', [
            'chat_id' => $chat_id,
            'text' => 'Ludzu izveleties option',
            'reply_markup' => $reply
        ]);
        return $response;
    }
    public function saveFile($url, $fileId){
        $path = "video/" . $fileId . '.mp4'; // Where the file should be saved to
        $link = $url; // Download link
        file_put_contents($path, file_get_contents($link));
    }
    public function makeSureNumber($chatid){
        if (empty($this->carNumber)){
         //   $this->sendMessage($chatid,'Please, provide Car Number');
            return false;
        }
        return true;
    }
    public function setCarNumber($car){
        $this->carNumber = $car;
    }

    /**
     * @return mixed
     */
    public function getCarNumber()
    {
        return $this->carNumber;
    }

    public function checkUser($thisUser) {
        $this->db =  new Model();
     //   $user = $this->db->selectAllFromTable('users');
      //  $user = $this->db->fetchAll('"select * from user');
        require_once ('kvazi_baza.php');
        $users = $this->db->selectAllFromTable($this->userTable);
     //   var_dump($users);die;
        $userdata = kvazi_baza::$user1;
        $status = false;
        if (!empty($users)) {
            foreach ( $users as $user) {
                //var_dump($user["idn"]);die;
                if ($user['idn'] == $thisUser ) {
                    $status = true;
                }
            }
}
        return $status;
    }
}
