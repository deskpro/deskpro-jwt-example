<?php

require_once "config.php";
require_once "AuthSystem.php";

$authSystem = new AuthSystem();

if (!$authSystem->isAuthenticated()) {
    header("Location: index.php");
}

$client = new \GuzzleHttp\Client(['cookies' => true]);
$jar = new \GuzzleHttp\Cookie\CookieJar;

$token = $authSystem->getToken($CONFIG);
$url = $CONFIG['deskpro_user_url'] . "agent/login/authenticate-callback/". $CONFIG['usersource_id']."?jwt=".$token;
$client->request('GET', $url, ['cookies' => $jar]);

$response = $client->request('GET', $CONFIG['deskpro_user_url'] . 'api/v2/me', ['cookies' => $jar]);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login (External Site)</title>
</head>
<body>
<h1>API Query</h1>

<pre>
    <?php echo $response->getBody() ?>
</pre>
