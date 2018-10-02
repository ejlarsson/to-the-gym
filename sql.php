<?php 


global $conn;

function connect() 
{
	$conn = pg_connect(getenv("DATABASE_URL"));
	if (!$conn) {
		echo "An error occurred.\n";
		exit;
	}
}

function validateUserPassword($login, $password)
{
	if ($password == '' || !isset($password)) {
		$query = 'SELECT * FROM tgg."user" WHERE login = ' . $login . ' AND not_secure_pw is null';
	}
	else {
		$query = 'SELECT * FROM tgg."user" WHERE login = ' . $login . ' AND not_secure_pw = ' . $password;
	}
	echo $query;
	$res = pg_query($conn, $query); 
	echo $res;
	if (!$res) return FALSE;
	if (pg_num_rows($res) == 0) return FALSE;
	return TRUE;
}

/*function retrieveExerciseForPeriod($period) {
	$res = pg_query('SELECT * FROM '$exercise);//' e INNER JOIN '$exercise_type' et ON et.id = e.exercise_type_id INNER JOIN 
	return $res;
}*/


?>