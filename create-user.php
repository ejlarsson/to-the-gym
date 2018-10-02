<?php

session_start();

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name'])) {
	
	include 'sql.php';
  
	if (createUser(getConnection(), $_POST['login'], $_POST['password'], $_POST['name']) == TRUE) {
		$_SESSION['login'] = $_POST['login']; //write login to server storage
		header('Location: /'); //redirect to main
	} else {
		echo "<script>alert('Could not create login');</script>";
		echo "<noscript>Could not create login</noscript>";
	}
}

?>

<form method="post">
	Login:<br><input name="login"><br>
	Password:<br><input name="password"><br>
	Name:<br><input name="name"><br>
	Bruk ikke et passord du vanligvis bruker da jeg ikke giddet at gjøre dette sikkert med kryptering. Happy hacking...<br>
	Kan nevnes at jeg ikke giddet skape noen valideringersfeil etc. så får du feil så er det noe som er feil med det du skrev inn :D
	<input type="submit">
</form>