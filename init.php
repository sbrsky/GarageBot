<?php
include ('vendor/autoload.php');
include ('TelegramBot.php');
include ('config.php');
include ('BotTextLib.php');
// Receive  text messages
$telegramApi = new TelegramBot();
$readyToRecieveNumberPlate = false;
$lib = new BotTextlib();
  var_dump('Ботик успешно запустило. Пока нет ошибочек, он работает-с');
while (true) {
    sleep(2);
    $updates = $telegramApi->getUpdates();

    $text ='Спасибо. Выберете что делать далее:';
    $carNumber = 'Вы редактируете ';
    if (!empty($telegramApi->getCarNumber())) {
        $carNumber .= $telegramApi->getCarNumber();
        $lib->text_ievadit = "Поменять редактируемую АвтоМашину";
    } else {
        $carNumber .= "НЕОПРЕДЕЛЕННО";
    }

    $keyMenu = array($lib->text_ievadit, $lib->text_galvenaMenu, $lib->text_uzzinat_numuru, );
    $keyAfterVideo = array($lib->text_turpinat, $lib->text_galvenaMenu,);
    $keyAfterMessage = array($lib->text_galvenaMenu, $lib->text_turpinat,);
    $keyGalvenaMenu = array($lib->text_galvenaMenu, $lib->help,);
    $keyCancel = array($lib->cancel);

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
            $telegramApi->sendMessage($chatid,$lib->textAvtorizationFault);
           // var_dump($chatid);
            break;
        }

        if (isset($update->message->video)) {
            //check if we have here right CarNumber, and video
            if (!$telegramApi->makeSureNumber($chatid)) {
                $text = $lib->noNumber;
                $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
            } else {
                // receive video
                /*
                 * We checking for video not exceeds 25mb
                 */
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
            if($incomingText == $lib->cancel) {
                $readyToRecieveNumberPlate = false;
                $telegramApi->sendMessageKeyboard($chatid, $keyMenu);
            }
            else if ($readyToRecieveNumberPlate && $incomingText != $lib->text_galvenaMenu) {
                if (!$telegramApi->checkCar(strtoupper($incomingText))){
                    $text = 'Такой машины в нашей базе данных нет :' . $telegramApi->carNumber . "\n Попробуйте еще раз";
                    $telegramApi->sendMessageKeyboard($chatid, $keyCancel);
                }
                else {
                    $telegramApi->setCarNumber(strtoupper($incomingText));
                    $readyToRecieveNumberPlate = false;
                    $text = 'Теперь вы редактируете машину :' . $telegramApi->carNumber;
                    $telegramApi->sendMessageKeyboard($chatid,$keyAfterMessage);
                }


            }
            else {
                $text_ievadit ='Ievadit_numuru';
                switch ($incomingText){
                    case "privet":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $text = "---";
                        break;
                    case "$lib->text_atpakal":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyAfterMessage);
                        $text = "---";
                        break;
                    case "$lib->text_turpinat":
                        $text = "с";
                        $telegramApi->sendMessageKeyboard($chatid,$keyAfterVideo);
                        $text = "---";
                        break;
                     case "$lib->text_galvenaMenu":
                        $text = "И ";
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $text = "---";
                        break;

                    case "/start":
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $telegramApi->sendPhoto($chatid);
                        $text = $lib->helloText;
                        break;
                    case "$lib->cancel":
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        $text = "---";
                        break;
                    case "$lib->text_ievadit":
                        $text = "Введите номер автотранспортного средства";
                        $readyToRecieveNumberPlate = true;
                        $telegramApi->sendMessageKeyboard($chatid, $keyCancel);
                        break;
                    case "/test":
                        $keyArray = array('Ievadit numuru', 'Atpakal');
                        $telegramApi->sendMessageKeyboard($chatid,$keyArray);
                        $text = ' KEyboard test';

                        break;
                    case "$lib->text_uzzinat_numuru":
                        if (!empty($telegramApi->getCarNumber())){
                            $text = "Ваше транспортное средство : " . $telegramApi->getCarNumber() . "\n It's ID : " . $telegramApi->getCarId();
                            $telegramApi->sendMessageKeyboard($chatid,$keyAfterVideo);
                        } else {
                            $text = 'Траснопортное средство не установлено';
                            $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                        }

                        break;
                    default:
                        $text = "Надо что-то решать, и писать какую-то команду";
                        $telegramApi->sendMessageKeyboard($chatid,$keyMenu);
                }
            }
        }
        $text .= $lib->defaultText;
        $text .= "\n" . $carNumber;
        $telegramApi->sendMessage($chatid,$text);
        }

}
