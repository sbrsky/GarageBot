<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.08.19
 * Time: 13:00
 */

class botTextLib
{
public $textAvtorizationFault;
public $text;
public $text_ievadit;
public $text_atpakal;
public $text_turpinat;
public $text_galvenaMenu;
public $text_uzzinat_numuru;
public $help;
public $noNumber;
public $usualText;
public $helloText;
    public $defaultText;
    public $cancel;

    /**
     * botTextLib constructor.
     */
    public function __construct()
    {
        $this->textAvtorizationFault = "Требуется Авторизация для продолжения. Запросите вход у себя на личной странице или администратора ";
        $this->text ='Paldies. Izveleties option';
        $this->text_ievadit ='Ввести_номер';
        $this->text_atpakal = 'Atpakal';
        $this->text_turpinat = 'Turpinat video upload';
        $this->text_galvenaMenu = 'В Главное меню';
        $this->text_uzzinat_numuru = "/Подробнее_о_Машине";
        $this->help = '/help';
        $this->noNumber = 'Не указан номер. Что бы добавить видео, пожалуйста укажите номер А\М';
        $this->defaultText .= "\n \n Вы используете сервис Дорфмана по загрузке Видео. Используйте меню внизу экрана что бы продолжить работу \n _Важно_ - Вы можете закачивать видео, только если указали номер А\М. НЕ забудьте проверить какую машину редактируете";
        $this->cancel = 'Отмена - Возврат в главное меню';
        $this->helloText = "ВАС приветствует самый лучший сервис. Мы починим ваш автомобиль, даже если это полное ведро! Приврзите к нам ваше цинковое чудо, и мы сделаем из него блестящий пример кулибиной смекалки!";


    }
}