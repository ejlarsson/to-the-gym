<?php

session_start();

if (isset($_POST['login']) && isset($_POST['name'])) {
	
	include_once 'sql.php';
		
	if (createUser(getConnection(), $_POST['login'], $_POST['name'], $_POST['password']) == TRUE) {
		$users = queryUsers($conn, NULL, $_POST['login']);
		$user = pg_fetch_row($res);
		$_SESSION['user_uuid'] = $user[1];
		header('Location: /'); //redirect to main
	} else {
		header('Location: /'); //redirect to main
		echo "<script>alert('Could not create login');</script>";
		echo "<noscript>Could not create login</noscript>";
	}
}

?>