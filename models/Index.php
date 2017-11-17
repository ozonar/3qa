<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 11.09.2017
 * Time: 21:13
 */

namespace models;

class Index
{
    public static function getBody($request, $defaultShortLink)
    {

        if ($request == '404') {
            echo HTML::render('404');
            return;
        }

        if ($request == '') {
            echo HTML::render('main', ['shortlink' => $defaultShortLink]);
            return;
        }

        echo "<a href='http://3qa.ru'>&crarr;</a>";

        $database = database::getDatabase();
        $stmt = $database->select('short', ['long', 'type'], ['little[=]' => $request]);

        if (empty($stmt)) {
            echo HTML::render('linkTypes/notExist', ['serverName' => $_SERVER["SERVER_NAME"], 'request' => ucfirst(strtolower($request))]);
            return;
        }

        $stmt = current($stmt);
        $fullLink = $stmt['long'];
//        $withoutSchemeLink = parse_url($stmt['long']); // TODO
//        unset($withoutSchemeLink['scheme']);
//        $withoutSchemeLink = http_build_url($withoutSchemeLink);;
        $type = $stmt['type'];

        $clearlink = $fullLink;
        $addn = '';

        switch ($type) {
            case Save::TYPE_TEXT:
                $clearlink = str_ireplace('/n', '<br>', $clearlink);
                $clearlink = str_ireplace('\n', '<br>', $clearlink);
                echo HTML::render('linkTypes/text', ['fullLink' => $clearlink]);
                break;
            case Save::TYPE_NO_RELINK:
                $fullLink = $addn . $clearlink;
                $shortLink = $clearlink;
                echo HTML::render('linkTypes/noRelink', ['fullLink' => $fullLink, 'shortLink' => $shortLink]);
                break;
            case Save::TYPE_IMAGE:
                $fullLink = $addn . $clearlink;
                echo HTML::render('linkTypes/image', ['fullLink' => $fullLink]);
                break;
            case Save::TYPE_RELINK:
                header('Location: ' . $addn . $clearlink);
                break;
        }

    }
}