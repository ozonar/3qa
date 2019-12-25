<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 18.11.2017
 * Time: 13:58
 */

namespace models;



class Config
{

    private static $config = [];


    public static function get()
    {

        if (!self::$config) {
            self::$config = require ('config.php');

        }
        return self::$config;
    }
}