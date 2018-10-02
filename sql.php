<?php 
function getConnection() {
	$conn = pg_connect(getenv("DATABASE_URL"));
	if (!$conn) {
		echo "An error occurred.\n";
		exit;
	}
	return $conn;
}
	
function validateUserPassword($conn, $login, $password) {
	if ($password == '' || !isset($password)) {
		$query = 'SELECT * FROM ttg."user" WHERE login = \'' . $login . '\' AND not_secure_pw is null';
	}
	else {
		$query = 'SELECT * FROM ttg."user" WHERE login = \'' . $login . '\' AND not_secure_pw = \'' . $password . '\'';
	}

	$res = pg_query($conn, $query); 
	
	if (!$res) return FALSE;
	if (pg_num_rows($res) == 0) return FALSE;
	return TRUE;
}

function createUser($conn, $login, $name, $password) {
	if (isset($password)) {
		$arr = array("login" => $login, "name" => $name, "not_secure_pw" => $password);
	} else {
		$arr = array("login" => $login, "name" => $name);
	}
	$res = pg_insert($conn, 'ttg."user"', $arr, 'PG_DML_ESCAPE');
	
	if ($res) {
		echo "POST data is successfully logged\n";
		return TRUE;
	} else {
		echo "User must have sent wrong inputs\n";
		return FALSE;
	}
}

/*function retrieveExerciseForPeriod($period) {
	$res = pg_query('SELECT * FROM '$exercise);//' e INNER JOIN '$exercise_type' et ON et.id = e.exercise_type_id INNER JOIN 
	return $res;
}*/


?>