<?php

session_start();

if (isset($_POST['login']) && isset($_POST['password'])) {
	
	include 'sql.php';
  
	if (validateUserPassword(getConnection(), $_POST['login'], $_POST['password']) == TRUE) {
		$_SESSION['login'] = $_POST['login']; //write login to server storage
		echo "<script>alert('Correct login or password');</script>";    
		//header('Location: /'); //redirect to main
	} else {
		echo "<script>alert('Wrong login or password');</script>";
		echo "<noscript>Wrong login or password</noscript>";
	}
}

?>

<form method="post">
  Login:<br>
		<input name="login">
			<br>
  Password:<br>
					<input name="password">
						<br>
							<input type="submit">
							</form>