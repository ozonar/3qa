<?php

use Main\Helper;
use models\database;
require_once('autoload.php');

$save = new models\Save();
$database = database::getDatabase();

//$database->insert("short", ["little" => "404", "long" => "102"]);
//$database->insert("short", ["little" => "102", "long" => "asd"]);

// Получаем данные
$longLink = Helper::requestString('link');
$shortLink = Helper::requestString('what');
$noRelink = Helper::requestString('auto');
$textOnly = Helper::requestString('nolink');
$isImage = Helper::requestBoolean('image');
$captcha = Helper::requestString('captha');

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
    if (!empty($dublicateResult)) {
        echo $save->resultExistDublicate()['message'];
        return;
    }
}
$type = $save->getType($noRelink, $textOnly, $isImage);

// Сохранить изображение или файл
if ($isImage == true) {
    if ($shortLink != '630077') {
        echo $save->resultWrongPassword()['message'];
        return;
    }

    $fileFrom = $longLink;
    $filenameFrom = basename($fileFrom);
    $uploadToDir = 'images/' . $filenameFrom;
    if (!copy($fileFrom, $uploadToDir)) {
        echo $save->resultDownloadError()['message'];
        return;
    }
    $longLink = 'images/' . basename($longLink);
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
    echo $save->resultSuccess($shortLink)['message'];
}

