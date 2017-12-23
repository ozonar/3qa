<?php

use Main\Helper;
use models\database;
require_once('autoload.php');

$save = new models\Save();
$database = database::getDatabase();


// Получаем данные
$longLink = Helper::requestString('link');
$shortLink = Helper::requestString('what');
$noRelink = Helper::requestString('auto');
$textOnly = Helper::requestString('nolink');
$captcha = Helper::requestString('captha');
$isImage = (boolean)Helper::requestString('image');

$userIp = $_SERVER["REMOTE_ADDR"];
$updateCurrentNumber = 0;

// Если пустая ссылка
if ($longLink == '') {
    echo $save->resultEmpty();
    return;
}

if (!$shortLink) {
    $shortLink = $save->getShortNumber();
    $updateCurrentNumber = 1;
} else {

    // Проверить базу на наличие короткой ссылки из текущего запроса
    $dublicateResult = $database->select('short', ['long'], ['little[=]' => $shortLink]);
    if (!empty($dublicateResult) && !$isImage) {
        echo $save->resultExistDublicate();
        return;
    }
}
$type = $save->getType($noRelink, $textOnly, $isImage);

// Сохранить изображение или файл
if ($isImage == true) {
    if ($shortLink != \models\Config::get()['save_image_password']) {
        echo $save->resultWrongPassword();
        return;
    }

//    echo "<pre>\n"; var_dump(__DIR__); echo "\n</pre>"; exit;
    $fileFrom = $longLink;
    $filenameFrom = basename($fileFrom);
    $uploadToDir = '/../images/' . $filenameFrom;
    
    if (!copy($fileFrom, $uploadToDir)) {
        echo $save->resultDownloadError();
        return;
    }
    $longLink = '../images/' . basename($longLink);
}

try {
    $result = $database->insert('short', [
        'type' => $type,
        'little' => $shortLink,
        'long' => $longLink,
        'ip' => $userIp,
    ]);

    if ($updateCurrentNumber) {
        $database->update('short', ['long' => $shortLink], ['little[=]' => 404]);
    }
} catch (Exception $e) {
    $save->resultErrorWhileSaving();
    return;
}

if (!empty($result)) {
    // Вы приняты. Распишитесь.
    echo $save->resultSuccess($shortLink);
}

