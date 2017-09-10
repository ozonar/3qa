<?php
// Подключение БД через PDO
$host="localhost";
$dbname="shorter";
$charset="UTF8";
$user="root";
$pass="Expl\$osion9200";


// Гуглокаптча
$secret_key = "6LfKfwYTAAAAANb9E_GrZ3zOa26KBsmQhhQCApAg";
$public_key = "6LfKfwYTAAAAAIFPeT0CSy6CA9s6mfRzudDNWt78";

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);

try {
$pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
     die("Конфигурация БД неверна. Это фатальная ошибка, обратитесь к администратору. <br> Подробности:". $e->getMessage());
}

