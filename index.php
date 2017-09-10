<!DOCTYPE HTML>
<html>
<head>

<!-- Кодирование -->
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta name='yandex-verification' content='595e54a28ff5ebed' />
 <meta name="google-site-verification" content="Ww7zu_aQeqn8ROJWS5446gasnWDuwvaGuvZUuLpQjeI" />
 
 <meta name="keywords" content="сокращалка ссылок, сокращение ссылки, сократи ссылку, уменьшить ссылку, сокращение ссылки, укоротить ссылку" />
 <meta name="description" content="Сокращалка ссылок. Тут можно сделать из длинной ссылки короткую, а также сохранить картинку">
 <meta name="version" content="2.3">
 <meta name="author" content="Максим Анархистов" />
 <meta name="copyright" lang="ru" content="Bright Studio" />
 <meta name="document-state" content="Static" />
 <meta name="robots" content="index,nofollow" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
<title>
Сокращалка ссылкок
</title>

<style type="text/css">

body {
	background: url("/data/back3.png");
	 }

.row {  margin:0!important;
		margin-top:2px!important;
}

</style>
	
<!--    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <script type="text/javascript" src="data/jquery-1.8.3.min.js"></script>
	<link href="data/bootstrap.min.css" rel="stylesheet">
	<script src="data/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	

    <script type="text/javascript">
        $(document).ready(function() {
			
            $('#short_button').click(function() {
                $.post('save.php', {link : $('#link').attr('value'),
									 what : $('#what').attr('value'),
									  auto : $('#auto').attr('checked'),
									   nolink : $('#nolink').attr('checked'),
										captcha : $('form').serialize()
				}, function(data) {
                    $('#user_data').html(data);
                });
            });
        });
    </script>
	
	
    <script type="text/javascript">
        $(document).ready(function() {
            $('#save_button').click(function() {
                $.post('save.php', {link : $('#link').attr('value'), 
									what : $('#what').attr('value'),
									 auto : $('#auto').attr('checked'),
									  image : 'checked',
									   nolink : $('#nolink').attr('checked')
				}, function(data) {
                    $('#user_data').html(data);
                });
            });		
        });
    </script>
	
	
  <script>
  jQuery(document).ready(function($) {
	
      $('[data-toggle="tooltip"]').tooltip({
			trigger: "hover",
			container: 'body'			
		});  

	 $('.dropdown-toggle').dropdown();
	 
	 $('#myModal').on('shown.bs.modal', function () {
		$('#myInput').focus()
	 })
		
    })
  </script>


<!-- Иконка _black-->
<link rel="shortcut icon" href="favicon.ico" type="image/ico">
    

</head>
 <body>
<?php

// Функция однократного перемещения. Чтобы выкинуть http
function str_ireplace_once($search, $replace, $text) 
{ 
   $pos = stripos($text, $search); 
   return $pos!==false ? substr_replace($text, $replace, $pos, strlen($search)) : $text; 
} 
//

// Сам линк 
if (isset($_REQUEST['request'])) { $request=$_REQUEST['request']; } else $request='';

// Эта строчка сразу вставится в поле короткой ссылки
if (isset($_REQUEST['shortlink'])) { $shortlink=$_REQUEST['shortlink']; } else $shortlink='';

if ($request=='404') {echo 'Ou shi! Ou fuck!';} else {

if ($request=='') 
  {									
	echo "

<div class='row'>
  <div class='col-md-3 col-md-offset-5'> 
   <div class='dropdown'>
	<div class='dropdown dropdown-toggle' data-toggle='dropdown' aria-expanded='true' role='button'>
		<img src='data/3qa.png' width='90' alt='3qa.ru'><span class='caret' aria-hidden='true'></span>
	</div>	
	<ul class='dropdown-menu' role='menu'>
		<li role='presentation'><a role='menuitem' tabindex='-1' href='#' data-toggle='modal' data-target='#inform'>Войти</a></li>
		<li role='presentation'><a role='menuitem' tabindex='-1' href='#' data-toggle='modal' data-target='#inform'>Зарегистрироваться </a></li>
		<li role='presentation'><a role='menuitem' tabindex='-1' href='#' data-toggle='modal' data-target='#inform'>Бонусные функции</a></li>
		<li role='presentation'><a role='menuitem' tabindex='-1' href='#' data-toggle='modal' data-target='#inform'>Что происходит?</a></li>
	</ul>
   </div>
  </div>
</div>



<div class='modal fade bs-example-modal-lg' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true' id='inform'>
<div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <h4 class='modal-title' id='myModalLabel'>Информация к размышлению</h4>
      </div>
      <div class='modal-body'>
        Привет! Этот сайт позволяет сделать из длинной ссылки короткую для быстрого её запоминания, а также создать для длинной ссылки ссылку-синоним вида <a href='http://".$_SERVER['SERVER_NAME']."/anything'>".$_SERVER['SERVER_NAME']."/anything</a>. На данный момент проект имеет базовую (вполне рабочую) функциональность, и не имеет специфических (хитрозадуманных) функций вроде запоминания всех ранее введенных ссылок и возможности их удалить (хотя тестовая страничка с этим функционалом уже <a href='http://admin.3qa.ru'>имеется</a>), но сервис будет развиваться и совершенствоваться.<br>
		<br>
		В дальнейшем планируется создать страницу при переходе по сокращенной ссылке, на которой будет размещен десятисекундный таймер с рекламой (или любой другой информацией), с помощью которой вы можете зарабатывать. Также планируются собственные поддомены, статистика, сохранение файлов по короткой ссылке, ссылка позволяющую отследить и сохранить данные посетившего её пользователя и торрент трекер (шутка).<br>
		<br>		
		Список текущих задач:<br>
		Сохранение картинок - тестовый режим (доступен при регистрации).<br>
		Регистрация - в разработке<br>
		Админка - в разработке <br>
		Сохранение данных пользователя - в разработке<br>
		Сохранение файлов - в планах<br>
		Реклама - в планах<br>
			
		
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Закрыть</button>
      </div>
    </div>
  </div>
</div>



	
<div class='row'>
  <div class='col-md-1 col-md-offset-4'> 
			Сюда&nbsp;ссылку:
  </div>
  
  
  <div class='col-md-3'>
  <div class='input-group'>
   <input type='text' class='form-control' id='link'>
      <span class='input-group-addon' rel='tooltip' data-toggle='tooltip' data-placement='bottom' title='Поставьте здесь галочку, если необходим просто текст. Будут работать перенос строк по /n и не будет ссылки'>
        <input type='checkbox' id='nolink'>
      </span>
  </div>
  </div>
</div>



<div class='row'>
  <div class='col-md-1 col-md-offset-4 example-1'> 
  
			3qa.ru/
	
	<a class='btn-mini btn-info' data-toggle='tooltip' data-placement='bottom' title='Сюда можно ввести короткую ссылку'>?</a>
  </div>
  
  
  <div class='col-md-3'>
  <div class='input-group'>
   <input type='text' class='form-control' id='what' value='$shortlink'>
      <span class='input-group-addon' rel='tooltip' data-toggle='tooltip' data-placement='bottom' title='Поставьте здесь галочку, если не хотите, чтобы перемещение на сайт происходило автоматически'>
        <input type='checkbox' id='auto'>
      </span>
  </div>
  </div>
  
  
  
</div>

<div class='row'>
  <div class='col-md-3 col-md-offset-5'> 
		<input type='submit' value='Сократить' class='searchfield btn btn-primary' name='submit' id='short_button'>		
		<input type='submit' value='Сохранить' class='searchfield btn btn' name='submit' id='save_button'>	
		<br>

  </div>
</div>

<br>

<div class='row'>
  <div class='col-md-4 col-md-offset-4'> 
		<div id='user_data'></div>
  </div>
</div>
";

  }
  else {
  
	$link_not_exists = true;
	
    include ("config.php");
	echo "<a href='http://3qa.ru'>&crarr;</a>";

		$stmt = $pdo->prepare('SELECT * FROM `short` WHERE `little` = ?');
		$stmt->execute([$request]);
		while ($tablerows = $stmt->fetch(PDO::FETCH_LAZY))
			
			{
				$link_not_exists = false;
			   $clearlink=$tablerows[3];
			     
					if  (stripos($clearlink, 'http://') < 5 and stripos($clearlink, 'http://') !== false) 
					{ $clearlink=str_ireplace_once('http://','',$clearlink); $addn='//'; }

			   else if  (stripos($clearlink, 'https://') < 5 and stripos($clearlink, 'https://') !== false) 
					{ $clearlink=str_ireplace_once('https://','',$clearlink); $addn='https://'; }	
					
			   else if  (stripos($clearlink, 'ftp://') < 5 	and stripos($clearlink, 'ftp://') !== false) 
					{ $clearlink=str_ireplace_once('ftp://','',$clearlink); $addn='ftp://'; }				

			   else if  (stripos($clearlink, '//') < 1 	and stripos($clearlink, '//') !== false) 
					{ $clearlink=str_ireplace_once('//','',$clearlink); $addn='//'; }					
			
			   else if  (stripos($clearlink, ':') < 10 	and stripos($clearlink, ':') !== false) 
					{  $addn=''; }					
					
			   else if  ((stripos($clearlink, '://') === false) or
						(stripos($clearlink, '://') >=7) ) $addn='//';
			   
			   else $addn='';
			   
			// --------

				echo "<div class='row'>
						<div class='col-md-3 col-md-offset-4'>"; 
							
					if ($tablerows[1]==12) // При отсутсвии форматирования добавляем переносы
						{
							$clearlink=str_ireplace('/n','<br>',$clearlink);		
							$clearlink=str_ireplace('\n','<br>',$clearlink);		
							echo "$clearlink";
						}
						
					if ($tablerows[1]==6)  echo "<a href='$addn$clearlink'>$clearlink</a>";
					
					if ($tablerows[1]==24) echo "<img width=400 src='$clearlink' alt='img'>";
/*							
							echo "	</div>
					 </div>
					 
		<script>		
			function relink() 
				{
					window.open('$addn$clearlink', '_parent');
				}
			if ($tablerows[1]===0) relink();
			</script>     ";
			
*/			if ($tablerows[1]==0)
			header ('Location: '.$addn.$clearlink);

			}
			
			// Если ничего не нашлось
			if ($link_not_exists) 
			{
				echo "
<div class='row'>
  <div class='col-md-5 col-md-offset-4'> 
		<b>Запрошенная вами ссылка не найдёна.</b> <br><br>
		Попробуйте уточнить почему её тут нет у человека который ваc сюда привёл. <br>
		Ну или не парьтсь и создайте новую ссылку на <a href = 'http://".$_SERVER['SERVER_NAME']."'> главной</a>.<br><br>
		Вы даже можете занять именно эту страницу, и все люди, пришедшие сюда могут попадать совершенно в другое место, мухаха! *потирает руки*. <a href='http://".$_SERVER['SERVER_NAME']."/?shortlink=".ucfirst(strtolower($request))."'>Вот тут </a> для этого уже всё подготовлено.
		<br>
  </div>
</div>";
			}
			
	}
} ?>



<div class='invisible'>Сокращалка ссылок. Максим Анархистов. ver 2.3 </div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter30166244 = new Ya.Metrika({
                    id:30166244,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/30166244" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


</body>
</html>
