<?php
include ('Model.php');
class TelegramBot
{
    protected $token = '914220148:AAHznTbsXetdo8vXtnSocEY4VJy8L39CWyg';
    protected $updateId;
    protected $userTable = 'bot_admin';
    protected $carTable = 'ser_masina';
    protected $nameTable = 'bot_customer';

    //Car variables;
    public $carNumber;
    protected $carId = 0;
    //Database
    protected $db;
    private $carEmail;

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
        $resp = array("keyboard" => $keyboard,"resize_keyboard" => false,"one_time_keyboard" => true);
        $reply = json_encode($resp);

        $response = $this->query('sendMessage', [
            'chat_id' => $chat_id,
            'text' => 'Вы продолжаете работу с БОТом Дорфмана. Пожалуйста выберете опцию из меню внизу экрана',
            'reply_markup' => $reply
        ]);
        return $response;
    }
    public function saveFile($url, $fileId){
        $path = "video/" . $fileId . '.mp4'; // Where the file should be saved to
        $link = $url; // Download link
        file_put_contents($path, file_get_contents($link));
        $this->saveFileToDatabase($fileId);
    }
    protected function saveFileToDatabase($fileId)
    {
        $arr = array(
            "image" => $fileId . ".mp4",
            "idCar" => $this->carId,
            "category" => 'v',
                "email" => $this->getCarEmail(),
            "carNumer" => $this->carNumber,
            "keyController" => $this->generateRandomString()
        );
        $this->db = new Model();
        $permitted = array("image","idCar","category","email","carNumer","keyController");
        $sql = "INSERT INTO $this->nameTable SET ".$this->pdoPrepareSql($permitted,$values,$arr);
        $this->db->insertToBase($sql,$values);
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

    public function checkUser($thisUser)
    {
        $this->db = new Model();
        //   $user = $this->db->selectAllFromTable('users');
        //  $user = $this->db->fetchAll('"select * from user');
        require_once('kvazi_baza.php');
        $users = $this->db->selectAllFromTable($this->userTable);
        //   var_dump($users);die;
        $userdata = kvazi_baza::$user1;
        $status = false;
        if (!empty($users)) {
            foreach ($users as $user) {
                //var_dump($user["idn"]);die;
                if ($user['idn'] == $thisUser) {
                    $status = true;
                }
            }
        }
        return $status;
    }
    public function checkCar($thisCarPlate)
    {
        $this->db = new Model();
        //   $user = $this->db->selectAllFromTable('users');
        //  $user = $this->db->fetchAll('"select * from user');
        $cars = $this->db->selectAllFromTable($this->carTable);
        //   var_dump($users);die;
        $status = false;
        if (!empty($cars)) {
            foreach ($cars as $car) {
              //  var_dump($car["mas_regnumer"]);die;
                if ($car['mas_regnumer'] == $thisCarPlate) {
                    $this->carId = $car['id_mas'];
                    $this->carEmail = $car['mas_email'];
                    $status = true;

                }
            }
        }
        return $status;
    }

    /**
     * @return int
     */
    public function getCarId()
    {
        return $this->carId;
    }
    public function pdoPrepareSql($permitted, &$values, $source = array())
    {
        $set = '';
        $values = array();

        if (!$source) $source = &$_POST;
        foreach ($permitted as $field) {
            if (isset($source[$field])) {
                $set.="`".str_replace("`","``",$field)."`". "=:$field, ";
                $values[$field] = $source[$field];
            }
        }
        return substr($set, 0, -2);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @return mixed
     */
    public function getCarEmail()
    {
        return $this->carEmail;
    }


}
