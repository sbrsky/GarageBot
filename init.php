<?php
include ('vendor/autoload.php');
include ('TelegramBot.php');
include ('config.php');
// Receive  text messages
$telegramApi = new TelegramBot();
$readyToRecieveNumberPlate = false;
  var_dump('Ботик успешно запустило. Пока нет ошибочек, он работает-с');
while (true) {
    sleep(2);
    $updates = $telegramApi->getUpdates();

    $text ='Paldies. Izveleties option';
    $text_ievadit ='Ievadit numuru';
    $text_atpakal = 'Atpakal';
    $text_turpinat = 'Turpinat video upload';
    $text_galvenaMenu = 'Galvena menu';
    $text_uzzinat_numuru = '/getnumberplate';

    $keyMenu = array($text_ievadit, $text_atpakal, $text_uzzinat_numuru);
    $keyAfterVideo = array($text_turpinat, $text_atpakal,);
    $keyAfterMessage = array($text_galvenaMenu, $text_turpinat);

    foreach ($updates as $update) {
      //  var_dump($update);die;
        if (isset($update->message)){
            $chatid = $update->message->chat->id;
        }
        else {
            $chatid = $update->edited_message->chat->id;
        }


        // Authorization check
        if (!$telegramApi->checkUser($chatid)){
            $telegramApi->sendMessage($chatid,"Tikai Autorizeti. Jauta Dorfman.lv administratoru" );
           // var_dump($chatid);
            break;
        }
        if (isset($update->message->video)) {
            //check if we have here right CarNumber, and video
            if (!$telegramApi->makeSureNumber($chatid)) {
                $text = 'Jums vajag uzradit numuru. Ludzu uzpiediet numuru';
                $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
            } else {
                // receive video
                if ($update->message->video->file_size < 25000000)
                {
                    $fileid = $update->message->video->file_id;
                    $url = $telegramApi->getFile($fileid);
                    $telegramApi->saveFile($url, $fileid);
                    $text = 'Видео успешно загружено на сервер';
                    $telegramApi->sendMessageKeyboard($chatid, $keyAfterMessage);
                }
                else {
                    $text = 'Видео не может больше 3минут или 25 мегабайт.';
                    $telegramApi->sendMessageKeyboard($chatid, $keyAfterMessage);
                }
            }
        }
        else if (isset($update->message->text)) {
            $incomingText = $update->message->text;
            if ($readyToRecieveNumberPlate) {
                $telegramApi->setCarNumber($incomingText);
                $readyToRecieveNumberPlate = false;
                $text = 'Теперь вы редактируете машину :' . $telegramApi->carNumber;
                $telegramApi->sendMessageKeyboard($chatid,$keyAfterMessage);
            }
            else {
                $text_ievadit ='Ievadit numuru';
                switch ($incomingText){
                    case "privet":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $text = "---";
                        break;
                    case "$text_atpakal":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyAfterMessage);
                        $text = "---";
                        break;
                    case "$text_turpinat":
                        $text = "с";
                        $telegramApi->sendMessageKeyboard($chatid,$keyAfterVideo);
                        $text = "---";
                        break;
                     case "$text_galvenaMenu":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $text = "---";
                        break;

                    case "/start":
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $telegramApi->sendPhoto($chatid);
                        $text = "ВАС приветствует самый лучший сервис. Мы починим ваш автомобиль, даже если это полное ведро! Приврзите к нам ваше цинковое чудо, и мы сделаем из него блестящий пример кулибиной смекалки!";
                        break;
                    case "жопа":
                        $text = "Ты сам жопа с ушами";
                        break;
                    case "$text_ievadit":
                        $text = "Введите номер автотранспортного средства";
                        $readyToRecieveNumberPlate = true;
                        break;
                    case "/test":
                        $keyArray = array('Ievadit numuru', 'Atpakal');
                        $telegramApi->sendMessageKeyboard($chatid,$keyArray);
                        $text = ' KEyboard test';

                        break;
                    case "/getnumberplate":
                        if (!empty($telegramApi->getCarNumber())){
                            $text = "Ваше транспортное средство : " . $telegramApi->getCarNumber();
                            $telegramApi->sendMessageKeyboard($chatid,$keyAfterVideo);
                        } else {
                            $text = 'Траснопортное средство не установлено';
                            $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        }

                        break;
                    default:
                        $text = "Надо что-то решать, и писать какую-то команду";
                }
            }
        }
        $text .= "\n /getnumberplate - Узнать номер автомашины //\n /Ievadit numuru - Ввести номер Автомашины \n _Важно_ - Вы можете закачивать видео, только если указали номер А\М. НЕ забудьте проверить какую машину редактируете";
        $telegramApi->sendMessage($chatid,$text);
        }

}
