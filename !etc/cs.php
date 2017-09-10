<?
include ("config.php");

$id='500';
$what='12312';
$link='sdv';
$ip="192";


// new data
$title = 'PHP Security';
$author = 'Jack Hijack';

// query
//$sql = "INSERT INTO `shorter`.`short` (little,long) VALUES (:title,:author)";
//$q = $pdo->prepare($sql);
//$q->execute(array(':author'=>$author,  ':title'=>$title));
				  
	try {			  
//$pdos = $pdo->prepare("INSERT INTO `shorter`.`short` (`id`, `little`, `long`,`ip`) VALUES (?,?,?,?)");
//$pdos -> execute(array($id,$what,$link,$ip));
//				$result -> execute(array($id, $what, $link, $ip));

//$stmt = $pdo->query("SELECT `long` FROM `short` WHERE `little` = '404' LIMIT 0 , 30;")->fetch();
//echo $stmt["long"];

//	$last_num = $pdo->query("SELECT `long` FROM `short` WHERE `little` = '404' LIMIT 0 , 30;")->fetch();
//	$last_num = $last_num["long"];
//	echo $last_num;
$last_num = 278;

// $sovpad=mysql_query("SELECT * FROM `short` WHERE `little` =$last_num+1;",$db);
		 // Совпадения?
		 $sovpad  = $pdo->prepare("SELECT `long` FROM `short` WHERE `little` LIKE ?");
		 $sovpad->execute(array($last_num+1));
		 $sovpad = $sovpad->fetch();
		 $sovpad = $sovpad['long'];
		 
		 $i=1;
			while ($sovpads == $last_num+$i) 
				{
					$i=$i+1;
					$sovpad  = $pdo->prepare("SELECT * FROM `short` WHERE `little` LIKE ?");
					$sovpad->execute(array($last_num+$i+1));
					$sovpad = $sovpad->fetch();
					$sovpads = $sovpad['long'];
					echo $sovpad['little'];
				}


//print_r ($data[0]);
echo $sovpad;



//$lastnum=mysql_query("SELECT * FROM `short` WHERE `little` = '404' LIMIT 0 , 30;",$db);
													 // смотрим последнее число
//		 $tablerows = mysql_fetch_row($lastnum);     // построчно

	}
catch(PDOException $e){
echo 'Error : '.$e->getMessage();
exit();
}

// рабоата
//		$last_num = $pdo->query("SELECT `long` FROM `short` WHERE `little` = '404' LIMIT 0 , 30;")->fetch();
//		$last_num = $last_num["long"];



	
	echo "|";
?>


<br><br>

	$sql = "INSERT INTO `shorter`.`short`
				(id, little, long, ip) VALUES (
						:id, :little, :long, :ip)";
				
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);       
	echo "12d2"; exit;	
			$stmt->bindParam(':little', $what, PDO::PARAM_STR); 
			$stmt->bindParam(':long', $link, PDO::PARAM_STR);
			$stmt->bindParam(':ip', $ip, PDO::PARAM_STR); 
			
			$stmt = $pdo->prepare($sql);
			$stmt->execute(); 
			echo "1";
			
			
			
			
			
			
			
			//		include ("safemysql.class.php");
		
		
//		$allowed = array("id","what","link","ip"); // allowed fields
//		$sql = "INSERT INTO `shorter`.`short` SET ".pdoSet($fields,$values);
//		$stm = $dbh->prepare($sql);
//		$stm->execute($values);

		

		//$data    = $stm->filterArray($allowed);
		//$sql     = "INSERT INTO `shorter`.`short` SET ?u";
		//$stm->query($id,$little,$long,$ip);

		//$data = array('id'=>$id,'what'=>$little,'link'=>$long,'ip'=>$ip);		
		//$sql  = "INSERT INTO `shorter`.`short` SET ?u";
		
		//if (!$stm->query($sql, $data)) echo "bad"; exit;
		
		
		$sql = "INSERT INTO `shorter`.`short`
				(id, little, long, ip) VALUES (
						:id, :little, :long, :ip)";
		
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);       
			echo "12d2"; exit;	
			$stmt->bindParam(':little', $what, PDO::PARAM_STR); 
			$stmt->bindParam(':long', $link, PDO::PARAM_STR);
			$stmt->bindParam(':ip', $ip, PDO::PARAM_STR); 
			
			$stmt = $pdo->prepare($sql);
			$stmt->exec(); 
			echo "1";
			