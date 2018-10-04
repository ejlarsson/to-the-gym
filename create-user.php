<?php
session_start();

if (!empty($_POST['login']) && !empty($_POST['name'])) {
	
	include_once 'sql.php';
	
	if(!empty($_POST['password'])) $password = $_POST['password'];
	$res = createUser(getConnection(), $_POST['login'], $_POST['name'], $password);
	if ($res) {
		echo 'got here<br>';
		
		$users = queryUsers($conn, NULL, $_POST['login']);
		$user = pg_fetch_row($res);
		
		$_SESSION['user_uuid'] = $user[1];
		$_SESSION['user_name'] = $user[2];
		
		echo 'uuid:'.$_SESSION['user_uuid'].' name:'.$_SESSION['user_name'] . ' user:' . empty($user) . $user;
		
		exit;
		header('Location: /');
	} else {
		exit;
		header('Location: /');
	}
}
?>