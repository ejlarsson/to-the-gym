<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['name'])) {
	
	include_once 'sql.php';
	
	if(!empty($_POST['password'])) $password = $_POST['password'];
	
	if (createUser(getConnection(), $_POST['login'], $_POST['name'], $password) === TRUE) {
		$users = queryUsers($conn, NULL, $_POST['login']);
		$user = pg_fetch_row($res);
		
		$_SESSION['user_uuid'] = $user[1];
		$_SESSION['user_name'] = $user[2];
		
		header('Location: /');
	} else {
		header('Location: /');
	}
}
?>