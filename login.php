<?php
session_start();

if (isset($_POST['login'])) {
	include_once 'sql.php';
	
	if (!empty($_POST['password'])) { 
		$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	} else { 
		$res = validateUserPassword(getConnection(), $_POST['login'], NULL);
	}
	
	if ($res) {
		$row = pg_fetch_row($res);
		
		$_SESSION['user_uuid'] = $row[0];
		$_SESSION['user_name'] = $row[1];
		
		header('Location: /');
	} else {
		header('Location: /');
	}
}
?>