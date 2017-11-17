<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 17.11.2017
 * Time: 21:40
 */

namespace models;

class database
{

    private static $database;


    public static function createNewDatabase()
    {
        self::$database = new Medoo(
            [
                'database_type' => 'mysql',
                'database_name' => 'shorter',
                'server' => 'localhost',
                'username' => 'root',
                'password' => 'Expl$osion9200',
                'charset' => 'utf8',
            ]
        );

    }

    /**
     * @return Medoo
     */
    public static function getDatabase()
    {
        if (!self::$database) {
            self::createNewDatabase();
        }
        return self::$database;
    }
}