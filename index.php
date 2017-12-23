<?php
require_once('autoload.php');
use Main\Helper;
use models\Index;

$defaultShortLink = Helper::requestString('shortlink', '');

$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request = parse_url($request);
$request = str_replace('/', '', current($request));

?>
<!DOCTYPE HTML>
<html>
<head>

    <!-- Кодирование -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name='yandex-verification' content='595e54a28ff5ebed'/>
    <meta name="google-site-verification" content="Ww7zu_aQeqn8ROJWS5446gasnWDuwvaGuvZUuLpQjeI"/>

    <meta name="keywords"
          content="сокращалка ссылок, сокращение ссылки, сократи ссылку, уменьшить ссылку, сокращение ссылки, укоротить ссылку"/>
    <meta name="description"
          content="Сокращалка ссылок. Тут можно сделать из длинной ссылки короткую, а также сохранить картинку">
    <meta name="version" content="2.3">
    <meta name="author" content="Максим Анархистов"/>
    <meta name="copyright" lang="ru" content="Bright Studio"/>
    <meta name="document-state" content="Static"/>
    <meta name="robots" content="index,nofollow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Сокращалка ссылкок
    </title>

    <script type="text/javascript" src="data/jquery-1.8.3.min.js"></script>
    <script src="data/main.js"></script>
    <link href="data/main.css" rel="stylesheet">
    <link href="data/bootstrap.min.css" rel="stylesheet">
    <script src="data/bootstrap.min.js"></script>
    <link rel="stylesheet" href="data/font-awesome/css/font-awesome.min.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/ico">
    <script src='https://www.google.com/recaptcha/api.js'></script>

</head>
<body>
<?php echo Index::getBody($request, $defaultShortLink); ?>

<div class='invisible'>Сокращалка ссылок. Максим Анархистов. ver 2.3</div>

<?php echo \models\HTML::render('counter'); ?>

</body>
</html>
