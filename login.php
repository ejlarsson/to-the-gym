<?php

session_start();

if (isset($_POST['login'])) {
	
	include_once 'sql.php';
	
	if (isset($_POST['password'])) { 
		$res = validateUserPassword(getConnection(), $_POST['login'], $_POST['password']);
	} else { 
		$res = validateUserPassword(getConnection(), $_POST['login']);
	}
	
	if ($res) {
		$row = pg_fetch_array($res);
		
		$_SESSION['user_uuid'] = $row[0];
		echo $_SESSION['user_uuid'];
		$_SESSION['user_name'] = $row[1];
		echo $_SESSION['user_name'];
				
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