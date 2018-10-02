<?php

session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
	
	include_once 'sql.php';
	$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	if ($res) {
		while ($row = pg_fetch_assoc($res)) {
			$_SESSION['login'] = $_POST['login'];
			echo $_SESSION['login'];
			$_SESSION['user_uuid'] = $row['uuid'];
			echo $_SESSION['user_uuid'];
			$_SESSION['user_name'] = $row['name'];
			echo $_SESSION['user_name'];
		}
			
		//header('Location: /'); //redirect to main
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