<?php
session_start();

if (isset($_POST['login'])) {
	include_once 'sql.php';
	
	if (isset($_POST['password']) && $_POST['password'] != '') { 
		$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	} else { 
		$res = validateUserPassword(getConnection(), $_POST['login'], NULL);
	}
	echo '<pre>'; print_r($res); echo '</pre>';
	exit;
	if ($res) {
		$_SESSION['user_uuid'] = pg_fetch_result($res, 0, 0);
		$_SESSION['user_name'] = pg_fetch_result($res, 0, 1);
		
		header('Location: /'); //redirect to main
	} else {
		header('Location: /'); //redirect to main
		echo "<script>alert('Wrong login or password');</script>";
		echo "<noscript>Wrong login or password</noscript>";
	}
}

?>