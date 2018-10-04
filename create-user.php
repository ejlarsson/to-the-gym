<?php
session_start();

if (isset($_POST['login']) && isset($_POST['name'])) {
	
	include_once 'sql.php';
		
	if (createUser(getConnection(), $_POST['login'], $_POST['name'], $_POST['password']) === TRUE) {
		$users = queryUsers($conn, NULL, $_POST['login']);
		$user = pg_fetch_row($res);
		
		$_SESSION['user_uuid'] = $user[1];
		$_SESSION['user_name'] = $user[2];
		echo $_SESSION['user_uuid'] . ' æ ' . $_SESSION['user_name'];
		exit;
		header('Location: /');
	} else {
		header('Location: /');
	}
}
?>