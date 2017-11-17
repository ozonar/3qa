<?php

//$db = new medoo([
//
//    'database_type'=>'mysql',
//    'database_name'=>'medoo',
//    'server'=>'localhost',
//    'username'=>'root',
//    'password'=>'',
//    'charset'=>'utf8',
//
//    'prefix'=>'slim_'
//
//]);

$db=mysqli_connect("localhost", "root", "Expl\$osion9200");
mysqli_select_db("shorter" ,$db);

