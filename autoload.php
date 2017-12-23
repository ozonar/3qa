<?php
/**
 * Created by PhpStorm.
 * User: mail
 * Date: 11.09.2017
 * Time: 21:11
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once ('models/database.php');
require_once ('models/Medoo.php');
\models\database::createNewDatabase();

require_once ('models/Config.php');
require_once ('models/render.php');
require_once ('models/Helper.php');
require_once ('models/Save.php');
require_once ('models/Index.php');

require_once("config.php");