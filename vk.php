<?php
error_reporting(E_ALL);
require_once('autoload.php');
use Main\Helper;

$vk_config = array(
    'app_id'        => '6316230',
    'api_secret'    => 'Mqf8D6S9Vz87miEA2mEY',
    'callback_url'  => 'http://3qa.ru/vk.php',
    'api_settings'  => 'friends'
    // If you need infinite token use key 'offline'.
);

$vk = new VK\VK('6316230', 'Mqf8D6S9Vz87miEA2mEY');

if (!isset($_REQUEST['code'])) {

    $authorize_url = $vk->getAuthorizeURL(
        $vk_config['api_settings'], $vk_config['callback_url'], true);

    echo '<a href="' . $authorize_url . '">Sign in with VK</a>';
} else {
    $access_token = $vk->getAccessToken($_REQUEST['code'], $vk_config['callback_url']);

    echo 'access token: ' . $access_token['access_token']
        . '<br />expires: ' . $access_token['expires_in'] . ' sec.'
        . '<br />user id: ' . $access_token['user_id'] . '<br /><br />';

    $user_friends = $vk->api('friends.get', array(
        'uid'       => '12345',
        'fields'    => 'uid,first_name,last_name',
        'order'     => 'name'
    ));

    foreach ($user_friends['response'] as $key => $value) {
        echo $value['first_name'] . ' ' . $value['last_name'] . ' ('
            . $value['uid'] . ')<br />';
    }
}

//$users = $vk->api('users.get', array(
//    'uids'   => 'rockcity,4321',
//    'fields' => 'first_name,last_name,sex'));
//
//echo "<pre>\n"; var_dump($users); echo "\n</pre>"; exit;

/*
$authUrl = $vk->getAuthorizeURL($vk_config['api_settings'], $vk_config['callback_url']);
$vk->getAccessToken('{CODE}');
$vk->isAuth(); // return bool

echo "<pre>\n"; var_dump($authUrl); echo "\n</pre>"; exit;*/
