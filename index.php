<?php

/**
 * This is a complete representation of an external website that uses SSO with DeskPRO
 */

require_once "config.php";
require_once "AuthSystem.php";

$authSystem = new AuthSystem();

// initiate login
if (isset($_POST['user'])) {
	$authSystem->login($_POST['user'], $_POST['pass']);

	// the jwt_initiated GET param is used only for this implementation and yours will differ.
	// the reason for this is so that we know to send the user to the "return" url after they login
	// because we set the jwt_initiatedd param if DeskPRO srtarted this auth request (see jwt_login.php).
	if (isset($_REQUEST['jwt_initiated']) && $_REQUEST['jwt_initiated']) {
		$loc = 'jwt_login.php';
		// ensure you keep passing the "return" GET param around properly.
		if (isset($_REQUEST["return"])) {
			$loc .= "?return=" . urlencode($_REQUEST["return"]);
		}
		header("Location: {$loc}");
		exit;
	}
}

// logout
if (isset($_GET['logout']) && $_GET['logout']) {
	$authSystem->logout();
}

if ($authSystem->isAuthenticated()) {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Login (External Site)</title>
	</head>
	<body>
	<h1>Welcome to (External Site)</h1>

	<p>You are logged in. <a href="index.php?logout=1">Logout</a></p>

	<h3>Company Nav</h3>
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="<?php echo $CONFIG['deskpro_agent_url']; ?>">Agent HelpDesk (DeskPRO)</a></li>
		<li><a href="<?php echo $CONFIG['deskpro_user_url']; ?>">User Support (DeskPRO)</a></li>
        <li><a href="query_api.php">Test API Query</a></li>
		<li><a href="index.php?logout=1">Logout</a></li>
	</ul>
	<h3>User Info</h3>
	<p>
		<pre>
<?php echo print_r($authSystem->getUser(), true); ?>
		</pre>
	</p>
	</body>
	</html>
<?php
} else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Login (External Site)</title>
	</head>
	<body>
	<h1>Login (External Site)</h1>

	<form action="index.php" method="POST">
		<?php if (isset($_REQUEST['jwt_initiated'])) { ?>
			<input type="hidden" name="jwt_initiated" value="1">
		<?php } ?>
		<?php if (isset($_REQUEST['return'])) { ?>
			<input type="hidden" name="return" value="<?php echo $_REQUEST['return']; ?>">
		<?php } ?>
		<table>
			<tr>
				<td>Username</td>
				<td><input type="text" name="user"></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="text" name="pass"></td>
			</tr>
			<tr>
				<td colspan="2">
					<button type="submit">Login</button>
				</td>
			</tr>
		</table>
	</form>

	</body>
	</html>
<?php
}
