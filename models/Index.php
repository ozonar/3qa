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
            return HTML::render('404');
        }

        if ($request == '') {
            return HTML::render('main', ['shortlink' => $defaultShortLink]);
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
//        $withoutSchemeLink = http_build_url($withoutSchemeLink);;
        $type = $stmt['type'];

        $siteReputation = Index::wotRequest($fullLink);

        if ($siteReputation < Config::get()['min_wot_reputation']) {
            $type = Save::TYPE_BAD_REPUTATION;
        }

        $clearlink = $fullLink;
        $addn = '';

        switch ($type) {
            default:
                return 'Empty';
            case Save::TYPE_TEXT:
                $clearlink = str_ireplace('/n', '<br>', $clearlink);
                $clearlink = str_ireplace('\n', '<br>', $clearlink);
                return HTML::render('linkTypes/text', ['fullLink' => $clearlink]);
            case Save::TYPE_NO_RELINK:
                $fullLink = $addn . $clearlink;
                $shortLink = $clearlink;
                return HTML::render('linkTypes/noRelink', ['fullLink' => $fullLink, 'shortLink' => $shortLink]);
            case Save::TYPE_IMAGE:
                $fullLink = $addn . $clearlink;
                return HTML::render('linkTypes/image', ['fullLink' => $fullLink]);
            case Save::TYPE_RELINK:
                header('Location: ' . $addn . $clearlink);
                return '';
            case Save::TYPE_BAD_REPUTATION:
                return HTML::render('linkTypes/badReputation', ['fullLink' => $fullLink]);
        }

    }

    public static function wotRequest($hosts)
    {
        $secret_key = Config::get()['wot_secret_key'];
        $reputation = 0;
        if ($curl = curl_init()) {

            $hosts = $hosts.'/';

            curl_setopt($curl, CURLOPT_URL, "api.mywot.com/0.4/public_link_json2?key=$secret_key&hosts=$hosts");
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $out = curl_exec($curl);
            $out = json_decode($out, true);//
            curl_close($curl);

            $reputation = @current($out)[0][0];
            $childReputation = @current($out)[4][0];

            $reputation = $reputation > $childReputation ? $reputation : $childReputation;

            if (!$reputation) {
                $reputation = 20;
            }

        }
            return $reputation;
    }


}