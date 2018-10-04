<?php
session_start();

if (isset($_POST['login'])) {
	include_once 'sql.php';
	
	if (isset($_POST['password']) && $_POST['password'] != '') { 
		$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	} else { 
		$res = validateUserPassword(getConnection(), $_POST['login'], NULL);
	}
	
	if ($res) {
		$row = pg_fetch_row($res);
		$_SESSION['user_uuid'] = $row[0];
		$_SESSION['user_name'] = $row[1];
		
		header('Location: /'); //redirect to main
	} else {
		header('Location: /'); //redirect to main
		echo "<script>alert('Wrong login or password');</script>";
		echo "<noscript>Wrong login or password</noscript>";
	}
}

?>