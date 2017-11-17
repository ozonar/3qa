<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 11.09.2017
 * Time: 21:14
 */

namespace Main;


class Helper
{

    public static function requestString($value)
    {

        if (isset($_REQUEST[$value])) {
            return self::filter($_REQUEST[$value], '');
        } else {
            return '';
        }
    }

    public static function requestBoolean($value)
    {

        if (isset($_REQUEST[$value])) {
            return self::filter($_REQUEST[$value], false);
        } else {
            return '';
        }
    }
    
    /**
     * Фильтрация строки от XSS
     * @param $var
     * @param $defaultValue
     * @return mixed|string
     * @internal param int $sql
     */
    public static function filter($var, $defaultValue = '')
    {
        if (!isset($var)) {
            return $defaultValue ? $defaultValue : '';
        }

        $var = str_replace("\n", "/n", $var);
        $var = str_replace("\r", "", $var);
        $var = str_ireplace('<br>', '/n', $var);

        $var = strip_tags($var); // html and php tags
        return $var;
    }

    public static function test()
    {
        return 'test';
    }

    /**
     * @param $captcha
     * @param $secret_key
     * @return array|bool|mixed
     */
    public static function google_curl($captcha, $secret_key)
    {
        return true;
        json_decode($captcha);
        $captcha = substr($captcha, 21);

        if ($curl == curl_init()) {
            curl_setopt($curl, CURLOPT_URL,
                'https://www.google.com/recaptcha/api/siteverify');
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=$secret_key&response=" . $captcha);
            $out = curl_exec($curl);
            $out = json_decode($out);

            $out = (array)$out;
            curl_close($curl);
            //print_r($out); echo "<br>";
            //echo $secret_key."?<br>";
            return $out['success'];
        }

        return [];
    }

    public static function generate_code($length = 5)
    {  // Not used NOW
        $num = rand(11111, 99999);
        $code = md5($num);
        $code = substr($code, 0, (int)$length);
        return $code;
    }
}