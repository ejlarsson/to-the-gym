<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['name'])) {
	
	include_once 'sql.php';
	
	if(!empty($_POST['password'])) $password = $_POST['password'];
	$res = createUser(getConnection(), $_POST['login'], $_POST['name'], $password);
	if ($res) {
		$user = pg_fetch_row($res);
		
		$_SESSION['user_uuid'] = $user[0];
		$_SESSION['user_name'] = $user[1];
		
		header('Location: /');
	} else {
		header('Location: /');
	}
}
?>