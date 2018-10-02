<?php

session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
	
	include_once 'sql.php';
	$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	if ($res) {
		$_SESSION['login'] = $_POST['login']; //write login to server storage
		$_SESSION['uuid'] = pg_fetch_result($res, 0, 0);
		$_SESSION['name'] = pg_fetch_result($res, 1, 0);
		header('Location: /'); //redirect to main
	} else {
		echo "<script>alert('Wrong login or password');</script>";
		echo "<noscript>Wrong login or password</noscript>";
	}
}

?>

<form method="post">
	Login:<br><input name="login"><br>
	Password:<br><input name="password"><br>
	<input type="submit">
</form>