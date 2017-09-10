<!DOCTYPE HTML>
<html>
<head>

<!-- Кодирование -->
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 
<title>
Админка. Запросы с IP адреса <? echo $_SERVER["REMOTE_ADDR"] ?>
</title>
</head>

<body>

<?php

include ("config.php");

$ip = $_SERVER["REMOTE_ADDR"];
			
$stmt = $pdo->prepare('SELECT * FROM `short` WHERE `ip` = ?');
$stmt->execute([$ip]);
while ($row = $stmt->fetch(PDO::FETCH_LAZY))
{
	if ((is_numeric($row[2])) && ($row[1]<12))
					echo "<font color='red'>".$row[2]."</font>    <a href='".$row[3]."'>".$row[3]."</a><br>";
				
}


?>

</body>
</html>