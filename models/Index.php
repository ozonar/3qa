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
    /**
     * @param $request
     * @param $defaultShortLink
     * @return false|mixed|string
     */
    public static function getBody($request, $defaultShortLink)
    {

        if ($request == '404') {
            return HTML::render('404');
        }

        if ($request == '') {
            return HTML::render('main', ['shortlink' => $defaultShortLink, 'serverName' => $_SERVER['SERVER_NAME']]);
        }

        $database = database::getDatabase();
        $stmt = $database->select('short', ['long', 'type'], ['little[=]' => $request]);

        if (empty($stmt)) {
            return HTML::render('linkTypes/notExist', ['serverName' => $_SERVER["SERVER_NAME"], 'request' => ucfirst(strtolower($request))]);
        }

        $stmt = current($stmt);
        $fullLink = $stmt['long'];
//        $withoutSchemeLink = parse_url($stmt['long']); // TODO
//        unset($withoutSchemeLink['scheme']);
//        $withoutSchemeLink = http_build_url($withoutSchemeLink);
        $type = $stmt['type'];

        switch ($type) {
            default:
                return 'Empty';
            case Save::TYPE_TEXT:
                $fullLink = str_ireplace("\n", '<br>', $fullLink);
                return HTML::render('linkTypes/text', ['fullLink' => $fullLink]);
            case Save::TYPE_NO_RELINK:
                return HTML::render('linkTypes/noRelink', ['fullLink' => $fullLink]);
            case Save::TYPE_IMAGE:
                return HTML::render('linkTypes/image', ['fullLink' => $fullLink]);
            case Save::TYPE_RELINK:
                echo '<script>window.location = "' . $fullLink . '"</script>';
                return '';
            case Save::TYPE_BAD_REPUTATION:
                return HTML::render('linkTypes/badReputation', ['fullLink' => $fullLink]);
            case Save::TYPE_EMPTY_REPUTATION:
                return HTML::render('linkTypes/emptyReputation', ['fullLink' => $fullLink]);
        }

    }
}