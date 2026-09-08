<?php

require_once "config.php";
require_once "AuthSystem.php";

$authSystem = new AuthSystem();

if (!$authSystem->isAuthenticated()) {
	$login_page = 'Location: index.php?jwt_initiated=1';
	// even if we need to request information from the user to authenticate them (as we do in this case)
	// we still MUST preserve the "return" GET param that we recieved.
	if (isset($_REQUEST["return"])) {
		$login_page .= "&return=" . urlencode($_REQUEST["return"]);
	}
	header($login_page);
	exit;
}

// The "return" URL tells us where to send the freshly-signed JWT. That JWT is a live credential,
// so we only ever redirect it to the host of our configured helpdesk URL -- never to whatever a
// caller happens to put in the query string, or anyone could point "return" at their own domain
// and have us hand them a valid token.
if (!isset($_REQUEST["return"])) {
	http_response_code(400);
	exit("Missing return URL.");
}

$dest_url = $_REQUEST["return"];
$dest_host = parse_url($dest_url, PHP_URL_HOST);
$allowed_host = parse_url($CONFIG['deskpro_user_url'], PHP_URL_HOST);

if (!$dest_host || strcasecmp($dest_host, $allowed_host) !== 0) {
	http_response_code(400);
	exit("Invalid return URL.");
}

$jwt = $authSystem->getToken($CONFIG);
/*
 * End generate JWT token
 ***********************************************************************/

// very important to always end up sending the user back to the "return" URL we provided to initiate the
// login request. This "return" param is NOT always the same.
if (strpos($dest_url, '?') === false) {
	$location = $dest_url . "?jwt={$jwt}";
} else {
	$location = $dest_url . "&jwt={$jwt}";
}

// Redirect
header("Location: " . $location);
