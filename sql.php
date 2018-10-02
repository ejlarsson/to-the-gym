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
	if ($password == '' || !isset($password)) {
		$query = 'SELECT * FROM ttg.exercise_user WHERE login = $1 AND not_secure_pw is null';
	}
	else {
		$query = 'SELECT uuid, name FROM ttg.exercise_user WHERE login = $1 AND not_secure_pw = $2';
	}
	
	return pg_query_params($conn, $query, array($login, $password)); 
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
	$query = 'SELECT p.name AS period, res.total AS number, b.number AS bid, b.bid_uuid AS bid_uuid FROM ttg.exercise_user eu INNER JOIN ttg.bid b ON eu.id = b.exercise_user_id RIGHT JOIN ttg.period p ON p.id = b.period_id LEFT JOIN (SELECT COUNT(ee.id) AS total, ee.bid_id AS bid FROM ttg.exercise ee GROUP BY ee.bid_id) res ON res.bid = b.id';
	if (isset($user_uuid)) $query = $query . ' WHERE eu.uuid = $1';
	if (isset($period))	$query = $query . ' AND p.name = $2';
	
	$query = $query . ' ORDER BY p.id ASC';
	
	return pg_query_params($conn, $query, array($user_uuid, $period));
}

/*function retrieveExerciseForPeriod($period) {
	$res = pg_query('SELECT * FROM '$exercise);//' e INNER JOIN '$exercise_type' et ON et.id = e.exercise_type_id INNER JOIN 
	return $res;
}*/


?>