
<?php
echo "ss";


$ch = curl_init('http://hm6.ru/poisk-po-bukve/%D8/');


curl_setopt($ch, CURLOPT_USERAGENT, 'IE20');
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, '1');


$text = curl_exec($ch);


//curl_close($ch);

preg_match_all("#class='b-listing-singers__item__name_m'><a href='\/([A-z0-9.-]+)\/'>([A-z�-�?)#", $text , $links );
print_r ($links[2]);
print_r ($links[1]);
