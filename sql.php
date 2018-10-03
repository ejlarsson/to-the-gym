<?php 
function getConnection() {
	$conn = pg_connect(getenv("DATABASE_URL"));
	if (!$conn) {
		echo "An error occurred.\n";
		exit;
	}
	return $conn;
}
	
function validateUserPassword($conn, $login, $password = NULL) {
	if (isset($password)) {
		$arr = array("login" => $login, "not_secure_pw" => $password);
		$query = 'SELECT uuid, name FROM ttg.exercise_user WHERE login = $1 AND not_secure_pw = $2';
	} else {
		$arr = array("login" => $login);
		$query = 'SELECT uuid, name FROM ttg.exercise_user WHERE login = $1 AND not_secure_pw is null';
	}
	
	return pg_query_params($conn, $query, $arr); 
}

function createUser($conn, $login, $name, $password = NULL) {
	if (isset($password)) {
		$arr = array("login" => $login, "name" => $name, "not_secure_pw" => $password);
	} else {
		$arr = array("login" => $login, "name" => $name);
	}
	$res = pg_insert($conn, 'ttg.exercise_user', $arr);
	
	if ($res) {
		echo "POST data is successfully logged\n";
		return TRUE;
	} else {
		echo "User must have sent wrong inputs\n";
		return FALSE;
	}
}

function queryBids($conn, $user_uuid = NULL, $period = NULL) {
	
	$query = 'SELECT p.name AS period, q2.bid AS bid, q2.total AS total FROM ttg.period p LEFT JOIN (SELECT b.period_id AS pid, b.number AS bid, q1.total AS total FROM ttg.bid b INNER JOIN ttg.exercise_user eu ON eu.id = b.exercise_user_id LEFT JOIN (SELECT ee.bid_id AS bid, COUNT(ee.id) AS total FROM ttg.exercise ee GROUP BY ee.bid_id) q1 ON q1.bid = b.id';

	$arr = array();
	if (isset($user_uuid)) { 
		$query = $query . ' WHERE eu.uuid = $1) q2 ON q2.pid = p.id';
		$arr[] = $user_uuid;
		if (isset($period))	{
			$query = $query . '  WHERE p.name = $2';
			$arr[] = $period;
		}
	}
	else {
		$query = $query . ') q2 ON q2.pid = p.id';
	}
	
	$query = $query . ' ORDER BY p.id ASC';
	
	return pg_query_params($conn, $query, $arr);
}

function queryExercises($conn, $user_uuid = NULL, $period = NULL, $exercise_uuid = NULL) {
	$query = 'SELECT eu.name AS user_name, eu.uuid AS user_uuid, p.name AS period, et.value AS exercise_type, e.exercise_duration_minutes AS exercise_duration, e.exercise_date AS exercise_date FROM ttg.exercise e INNER JOIN ttg.bid b ON b.id = e.bid_id INNER JOIN ttg.exercise_user eu ON eu.id = b.exercise_user_id INNER JOIN ttg.period p ON p.id = b.period_id LEFT JOIN ttg.exercise_type et ON et.id = e.exercise_type_id';
	$arr = array();
	
	if (isset($user_uuid) OR isset($period) OR isset($exercise_uuid)) {
		$query = $query . " WHERE ";
		$count = 1;
		if(isset($user_uuid)) {
			$query = $query . "eu.uuid = $".$count;
			$arr[] = $user_uuid;
			$count++;
		}
		if(isset($period)) {
			$query = $query . "p.name = $".$count;
			$arr[] = $period;
			$count++;
		}
		if(isset($exercise_uuid)) {
			$query = $query . "e.uuid = $".$count;
			$arr[] = $exercise_uuid;
			$count++;
		}
	}
	
	$query = $query . " ORDER BY e.exercise_date ASC;";	
	return pg_query_params($conn, $query, $arr);
		
}

/*function retrieveExerciseForPeriod($period) {
	$res = pg_query('SELECT * FROM '$exercise);//' e INNER JOIN '$exercise_type' et ON et.id = e.exercise_type_id INNER JOIN 
	return $res;
}*/


?>