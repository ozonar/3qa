<?php

include ("db.php"); error_reporting(0); // Подключаем БД
include ("config.php");

function filter( $var , $sql = 0) { // Фильтрация строки от XSS

	$var=str_replace ("\n","/n", $var);
        $var=str_replace ("\r","", $var);
	$var=str_ireplace('<br>','/n',$var); 
	
	$var = strip_tags($var); // html and php tags
	if ( $sql == 1) { 
		$var = mysql_real_escape_string($var);
	}
	return $var;
	}
	
function google_curl ($captcha, $secret_key) {
		json_decode($captcha);
		$captcha=substr($captcha,21);
	
		if( $curl == curl_init() ) {
		curl_setopt($curl, CURLOPT_URL, 
			'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, "secret=$secret_key&response=".$captcha);
		$out = curl_exec($curl);
		$out = json_decode($out);
		
		$out = (array)$out;
		curl_close($curl);
		//print_r($out); echo "<br>";
		//echo $secret_key."?<br>";
		return $out['success'];
		}
}
	
function generate_code($length = 5){  // Not used NOW
    $num = rand(11111, 99999);
    $code = md5($num);
    $code = substr($code, 0, (int)$length);
    return $code;
}

	
// Получаем данные с предыдущей формы
	$link=    filter($_REQUEST['link']);
	$what=    filter($_REQUEST['what']);
	$auto=    $_REQUEST['auto'];
	$nolink=  $_REQUEST['nolink'];
	$image=   $_REQUEST['image'];
	$captcha= $_REQUEST['captcha'];

// Костыль для сохранения картинки/файла
	if (($what=='630077') and ($image==true)) {
		$passw = $what;
		$what = '';
	}	
  
// Обработка исключения если в поле ссылки нет ничего
	if  ($link=='') 
	{
			 echo " <div class='alert alert-danger' role='alert'>
						<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
						Нет ничего же!
					</div>"; 		
	}
else {	
			
	// Обработка исключения если в поле сокращения нет ничего. Тогда присваиваем цифру
	if ($what=='') 
		{
			
		// Каптча проверка	
		if (!google_curl($captcha,$secret_key)) 
		{
			$result=mysql_query("SELECT `ip` FROM `short` WHERE `long` LIKE '$link';",$db);
			while ($tablerows = mysql_fetch_row($result))
			{
				
				if ($tablerows[0] == $_SERVER["REMOTE_ADDR"]) 
				{
					echo "<div class='alert alert-danger' role='alert'>
							<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
							Подозрительный вы какой-то. Пройдите тест:
						  </div>"; 
					
					echo "<form id='mainform'><div class='g-recaptcha' data-sitekey='$public_key'></div></form> <script src='https://www.google.com/recaptcha/api.js'></script>";
					exit;
					
				}
			}
		}	
		
	
						// смотрим последнее число (PDO)
		 $last_num = $pdo->query("SELECT `long` FROM `short` WHERE `little` = '404' LIMIT 0 , 30;")->fetch();
		 $last_num = $last_num["long"];
		
		 // Совпадения?
		 $sovpad  = $pdo->prepare("SELECT `long` FROM `short` WHERE `little` LIKE ?");
		 $sovpad->execute(array($last_num+1));
		 $sovpad = $sovpad->fetch();
		 $sovpad = $sovpad['long'];

		$i=1;			
			while ($sovpad == $last_num+$i) 
				{
					$i=$i+1;
					$sovpad  = $pdo->prepare("SELECT `long` FROM `short` WHERE `little` LIKE ?");
					$sovpad->execute(array($last_num+$i+1));
					$sovpad = $sovpad->fetch();
					$sovpad = $sovpad['long'];
				}
				$what=$last_num+$i;

				mysql_query("UPDATE `shorter`.`short` SET `long` = $what WHERE `short`.`id` =100 AND `short`.`little` = '404';",$db);
		}
	// Конец присвоения цифры

$abp=mysql_query("SELECT * FROM `short` WHERE `little` = '$what' ",$db);    // проверка на повторение
$apb=mysql_fetch_row($abp);													// костыль или нет?

if ( $apb=='') 
	{
	if ($auto==true) { $id=6; } else { $id=0; } // Если 6 - релинка не будет, если 0 - будет
	if ($nolink==true) { $id=12; } // Если 12 - покажу без ссылки. Костыль, да.
	
	// Сохранить изображение или файл
	if ($image==true) 
		{
			if ($passw!='630077') {
				echo "<div class='alert alert-danger' role='alert'>
						<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
						Для данной функции необходим пароль
					  </div>"; 
				exit;
			}
			
			$id=24;
			$fileFrom = $link;
			$filenameFrom = basename($fileFrom);
			$uploadToDir = 'images/'.$filenameFrom; //path путь на нашем сервере
			if (!copy($fileFrom, $uploadToDir)) {
				echo "<div class='alert alert-danger' role='alert'>
						<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
						Неопознанная ошибка загрузки $uploadToDir
					   </div>"; 
				exit;
			}
			$link='images/'.basename($link);
		}

		// Всё, сохраняем (PDO)
		$ip = $_SERVER["REMOTE_ADDR"];
		
			try {			  
				$result = $pdo->prepare("INSERT INTO `shorter`.`short` (`id`, `little`, `long`,`ip`) VALUES (?,?,?,?)");
				$result -> execute(array($id, $what, $link, $ip));
				}
			catch(PDOException $e){
					echo " <div class='alert alert-danger' role='alert'>
							<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
							Сайт допустил недопустимое, выполнил невыполнимое.
							</div>";
					exit();
				}

			if ($result>0) {
			echo "<div class='alert alert-success' role='alert'>Запись добавлена. Короткая ссылка:  
					<a href='http://".$_SERVER['SERVER_NAME']."/".$what."' >".$_SERVER['SERVER_NAME']."/".$what."</a></div>";}  
					// Вы приняты. Распишитесь.
	} 
	else
		echo " <div class='alert alert-danger' role='alert'>
				<span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
				Такой индентификатор уже существует
			   </div>";
				// ...идите нахуй
	
} // Закрытие условия, есть ли что-то в поле ссылки
	mysql_close($db);
?>