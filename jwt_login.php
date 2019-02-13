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

$jwt = $authSystem->getToken($CONFIG);
/*
 * End generate JWT token
 ***********************************************************************/

// very important to always end up sending the user back to the "return" URL we provided to initiate the
// login request. This "return" param is NOT always the same.
$dest_url = $_REQUEST["return"];
if (strpos($dest_url, '?') === false) {
	$location = $dest_url . "?jwt={$jwt}";
} else {
	$location = $dest_url . "&jwt={$jwt}";
}

// Redirect
header("Location: " . $location);
