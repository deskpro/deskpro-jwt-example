<?php

include "vendor/autoload.php";

$CONFIG = array();

//
// the JWT secret that is used to create the token.
// this is secret to you and should be very difficult to guess.
// you will use this value when you install the JWT app on your helpdesk.
//
$CONFIG['secret'] = "deskpro_secret";

//
// OPTIONAL
// make these URLs match the user portal and the agent url of your helpdesk
// so that you can emulate clicking links in your own site to the helpdesk
//
$CONFIG['deskpro_user_url'] = "http://localhost:8888/"; // just used as a link in the login area
$CONFIG['deskpro_agent_url'] = $CONFIG['deskpro_user_url'] . "/agent"; // just used as a link in the login area
$CONFIG['usersource_id'] = '3';
