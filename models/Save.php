<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 11.09.2017
 * Time: 21:13
 */

namespace models;

use Main\Helper;

class Save
{


    const ANSWER_EXISTED = 1;
    const ANSWER_WRONG_PASSWORD = 2;
    const ANSWER_EMPTY = 3;
    const ANSWER_ENTER_CAPTCHA = 4;

    const TYPE_NO_RELINK = 6;
    const TYPE_RELINK = 2;
    const TYPE_IMAGE = 3;
    const TYPE_TEXT = 12;
    const TYPE_BAD_REPUTATION = 13;
    const TYPE_EMPTY_REPUTATION = 14;


    // Получаем данные с предыдущей формы
    private $database;

    public $link;
    public $what;
    public $auto;
    public $nolink;
    public $image;
    public $captcha;

    public function __construct()
    {
        $this->database = database::getDatabase();
    }

    public function getShortNumber()
    {

        // Смотрим последнее число

        // Каптча проверка
//        if (!google_curl($captcha, $secret_key) && false) {
//            $result = mysqli_query("SELECT `ip` FROM `short` WHERE `long` LIKE '$link';", $db);
//            while ($tablerows = mysqli_fetch_row($result)) {
//
//                if ($tablerows[0] == $_SERVER["REMOTE_ADDR"]) {
//                    echo $save->resultCaptcha($public_key);
//                    exit;
//
//                }
//            }
//        }

        $lastNumber = $this->database->select('short', ['long'], ['short.little[=]' => '404']);

        if (!$lastNumber) {
             $this->database->insert('short', [
                'type' => 0,
                'little' => 404,
                'long' => 101,
                'ip' => $_SERVER["REMOTE_ADDR"],
            ]);
        }

        $savedNumber = isset(current($lastNumber)['long']) ? current($lastNumber)['long'] : 101;

        do {
            $savedNumber++;
            $sovpad = $this->database->select('short', ['long', 'little'], ['little[=]' => $savedNumber]);
        } while (!empty($sovpad));

        return $savedNumber;
    }

    public function getType($noRelink, $textOnly, $isImage)
    {
        $type = self::TYPE_RELINK;
        if ($noRelink) {
            $type = self::TYPE_NO_RELINK;
        }

        if ($textOnly) {
            $type = self::TYPE_TEXT;
        }

        if ($isImage) {
            $type = self::TYPE_IMAGE;
        }

        return $type;
    }


//    public function captcha($captcha)
//    {
//        $secret_key = Config::get()['secret_key'];
//        $public_key = Config::get()['public_key'];
//
//        // Каптча проверка
//        if (!Helper::google_curl($captcha, $secret_key)) {
//            $result = $this->database->select('short', 'ip', ['long[LIKE]' => $link]);
//            if (current($result['id']) == $_SERVER["REMOTE_ADDR"]) {
//                echo $this->resultCaptcha($public_key);
//            }
//        }
////            $result = mysqli_query("SELECT `ip` FROM `short` WHERE `long` LIKE '$link';", $db);
////            while ($tablerows = mysqli_fetch_row($result)) {
////
////                if ($tablerows[0] == $_SERVER["REMOTE_ADDR"]) {
////                    echo $save->resultCaptcha($public_key);
////                    exit;
////
////                }
////            }
//
//        // смотрим последнее число (PDO)
//        $last_num = $pdo->query("SELECT `long` FROM `short` WHERE `little` = '404' LIMIT 0 , 30;")->fetch();
//        $last_num = $last_num["long"] ? $last_num["long"] : 101;
//
//        // Совпадения?
//        $sovpad = $pdo->prepare("SELECT `long` FROM `short` WHERE `little` LIKE ?");
//        $sovpad->execute(array($last_num + 1));
//        $sovpad = $sovpad->fetch();
//        $sovpad = $sovpad['long'];
//
//        $i = 1;
//        while ($sovpad == $last_num + $i) {
//            $i = $i + 1;
//            $sovpad = $pdo->prepare("SELECT `long` FROM `short` WHERE `little` LIKE ?");
//            $sovpad->execute(array($last_num + $i + 1));
//            $sovpad = $sovpad->fetch();
//            $sovpad = $sovpad['long'];
//        }
//        $what = $last_num + $i;
//
//        mysqli_query("UPDATE `shorter`.`short` SET `long` = $what WHERE `short`.`little` = '404';", $db);
//    }

    public function resultEmpty()
    {
        return HTML::render('answerTypes/empty');
    }

    public function resultCaptcha($public_key)
    {
        return HTML::render('answerTypes/needEnterCaptcha', ['publicKey' => $public_key]);
    }

    public function resultExistDublicate()
    {
        return HTML::render('answerTypes/existedIndentifier');
    }

    public function resultWrongPassword()
    {
        return HTML::render('answerTypes/needPassword');
    }

    public function resultDownloadError()
    {
        return HTML::render('answerTypes/loadingError');
    }

    public function resultErrorWhileSaving()
    {
        return HTML::render('answerTypes/error');
    }

    public function resultSuccess($shortLink)
    {
        return HTML::render('answerTypes/success', ['serverName' => $_SERVER['SERVER_NAME'], 'shortLink' => $shortLink]);
    }
}