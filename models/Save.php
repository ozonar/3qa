<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 11.09.2017
 * Time: 21:13
 */

namespace models;

class Save
{


    const ANSWER_EXISTED = 1;
    const ANSWER_WRONG_PASSWORD = 2;

    const TYPE_NO_RELINK = 6;
    const TYPE_RELINK = 2;
    const TYPE_IMAGE = 3;
    const TYPE_TEXT = 12;
    const TYPE_BAD_REPUTATION = 13;


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


    public function set_global_parameters()
    {
        // Получаем данные с предыдущей формы
        $this->link = filter($_REQUEST['link']);
        $this->what = filter($_REQUEST['what']);
        $this->auto = $_REQUEST['auto'];
        $this->nolink = $_REQUEST['nolink'];
        $this->image = $_REQUEST['image'];
        $this->captcha = $_REQUEST['captcha'];
    }

    public function test()
    {
        return '23';
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
        $lastNumber = isset(current($lastNumber)['long']) ? current($lastNumber)['long'] : 101;

        $savedNumber = $lastNumber;
        do {
            $savedNumber++;
            $sovpad = $this->database->select('short', ['long', 'little'], ['little[=]' => $savedNumber]);
        } while (!empty($sovpad));

        return $savedNumber;
    }

    public function getType($noRelink, $textOnly, $isImage)
    {
        $type = Save::TYPE_RELINK;
        if ($noRelink) {
            $type = Save::TYPE_NO_RELINK;
        }

        if ($textOnly) {
            $type = Save::TYPE_TEXT;
        }

        if ($isImage) {
            $type = Save::TYPE_IMAGE;
        }

        return $type;
    }
    

//    public function captcha()
//    {
//
//        // Каптча проверка
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
        return " <div class='alert alert-danger' role='alert'>
						<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
						Нет ничего же!
					</div>";
    }

    public function resultCaptcha($public_key)
    {
        $result = "<div class='alert alert-danger' role='alert'>
							<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
							Подозрительный вы какой-то. Пройдите тест:
						  </div>";

        $result .= "<form id='mainform'><div class='g-recaptcha' data-sitekey='$public_key'></div></form> <script src='https://www.google.com/recaptcha/api.js'></script>";

        return $result;

    }

    public function resultExistDublicate()
    {
        return ['code' => self::ANSWER_EXISTED, 'message' => 'Такой индентификатор уже существует'];
    }

    public function resultWrongPassword()
    {
        return ['code' => self::ANSWER_WRONG_PASSWORD, 'message' => 'Неверный пароль'];
    }

    public function resultDownloadError()
    {
        return ['code' => self::ANSWER_WRONG_PASSWORD, 'message' => 'Неверный пароль'];
    }

    public function resultErrorWhileSaving()
    {
        return ['code' => self::ANSWER_WRONG_PASSWORD, 'message' => 'Сайт допустил недопустимое, выполнил невыполнимое.'];
    }

    public function resultSuccess($shortLink)
    {
        $serverName = $_SERVER['SERVER_NAME'];
        return ['code' => self::ANSWER_WRONG_PASSWORD, 'message' => "Запись добавлена. Короткая ссылка:  
					<a href='http://" . $serverName . "/" . $shortLink . "' >" . $serverName . "/" . $shortLink . "</a>"
					];
    }
}