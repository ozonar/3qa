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
        $config = [];
        try {
            $config = require_once ('config.php');
        } catch (\Exception $e) {
            echo 'Create config.php file in root: <br> cp config.dist.php config.php';
        }
        self::$database = new Medoo(
            [
                'database_type' => $config['dbtype'],
                'database_name' => $config['dbname'],
                'server' => $config['host'],
                'username' => $config['username'],
                'password' => $config['password'],
                'charset' => $config['charset'],
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