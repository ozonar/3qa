<pre>
<?

$ch = curl_init('http://hm6.ru/poisk-po-bukve/%D8/');

// Параметры курла
curl_setopt($ch, CURLOPT_USERAGENT, 'IE20');
curl_setopt($ch, CURLOPT_HEADER, 0);
// Следующая опция необходима для того, чтобы функция curl_exec() возвращала значение а не выводила содержимое переменной на экран
curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');

// Получаем html
$text = curl_exec($ch);


//curl_close($ch);

preg_match_all("#class='b-listing-singers__item__name_m'><a href='\/([A-z0-9.-]+)\/'>([^<]+)<\/a#", $text , $links );
 
//iconv("windows-1251","utf-8", $links);
print_r ($links[2]);
print_r ($links[1]);

//echo $links[1][0];

?>