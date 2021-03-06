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
		$query = 'INSERT INTO ttg.exercise_user (login, name, not_secure_pw) VALUES ($1, $2, $3) RETURNING uuid, name;';
		$arr = array($login, $name, $password);
	} else {
		$query = 'INSERT INTO ttg.exercise_user (login, name) VALUES ($1, $2) RETURNING uuid, name;';
		$arr = array($login, $name);
	}
	
	return pg_query_params($conn, $query, $arr);
}

function queryBids($conn, $user_uuid = NULL, $period_status = NULL) {
	
	$query = 	'SELECT p.name AS period_name, p.status AS period_status, q2.bid AS bid, q2.total AS total, q2.duration AS duration '.
				'FROM ttg.period p LEFT JOIN ('.
					'SELECT b.period_id AS pid, b.number AS bid, COALESCE(q1.total,0) AS total, COALESCE(q1.duration,0) AS duration '.
					'FROM ttg.bid b INNER JOIN ttg.exercise_user eu ON eu.id = b.exercise_user_id LEFT JOIN ('.
						'SELECT ee.bid_id AS bid, COUNT(ee.id) AS total, SUM(exercise_duration_minutes) AS duration '.
						'FROM ttg.exercise ee GROUP BY ee.bid_id) q1 ON q1.bid = b.id';

	$arr = array();
	if (isset($user_uuid)) { 
		$query = $query . ' WHERE eu.uuid = $1) q2 ON q2.pid = p.id';
		$arr[] = $user_uuid;
		if (isset($period_status))	{
			$query = $query . '  WHERE p.status = $2';
			$arr[] = $period_status;
		}
	}
	else {
		$query = $query . ') q2 ON q2.pid = p.id';
	}
	
	$query = $query . ' ORDER BY p.id ASC';
		
	return pg_query_params($conn, $query, $arr);
}

function queryExercises($conn, $user_uuid = NULL, $period = NULL, $exercise_uuid = NULL) {
	$query = 'SELECT eu.name AS user_name, eu.uuid AS user_uuid, p.name AS period, et.value AS exercise_type, e.exercise_duration_minutes AS exercise_duration, e.exercise_date AS exercise_date, b.uuid AS bid_uuid FROM ttg.exercise e INNER JOIN ttg.bid b ON b.id = e.bid_id INNER JOIN ttg.exercise_user eu ON eu.id = b.exercise_user_id INNER JOIN ttg.period p ON p.id = b.period_id LEFT JOIN ttg.exercise_type et ON et.id = e.exercise_type_id';
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
			if ($count > 1) $query = $query . " AND ";
			
			if($period === 'CURRENT') {
				$query = $query . "p.status = $".$count;
			} else {
				$query = $query . "p.name = $".$count;
			}
			
			$arr[] = $period;
			$count++;
		}
		if(isset($exercise_uuid)) {
			if ($count > 1) $query = $query . " AND ";
			$query = $query . "e.uuid = $".$count;
			$arr[] = $exercise_uuid;
			$count++;
		}
	}
	
	$query = $query . " ORDER BY e.exercise_date ASC;";	
	return pg_query_params($conn, $query, $arr);
}

function createExercise($conn, $user_uuid, $date, $duration = NULL, $type = NULL) {
	$arr = array();
	$arr["exercise_date"] = $date;
	if(isset($duration)) $arr["exercise_duration_minutes"] = $duration;
	if(isset($type)) $arr["exercise_type_id"] = $type;
	$bid_id = retrieveCurrentBidId($conn, $user_uuid);
	if(isset($bid_id)) $arr["bid_id"] = $bid_id; else return FALSE;
	
	$res = pg_insert($conn, 'ttg.exercise', $arr);
	
	if ($res) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function createBid($conn, $user_uuid, $bid) {
	$bid_id = retrieveCurrentBidId($conn, $user_uuid);
	if(isset($bid_id)) return FALSE;

	$periods = queryPeriods($conn, 'CURRENT');
	$period = pg_fetch_row($periods);
	
	$users = queryUsers($conn, $user_uuid);
	$user = pg_fetch_row($users);
	
	$arr = array();
	$arr["number"] = $bid;
	$arr["exercise_user_id"] = $user[0];
	$arr["period_id"] = $period[0];
	
	$res = pg_insert($conn, 'ttg.bid', $arr);
	
	if ($res) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function retrieveCurrentBidId($conn, $user_uuid) {
	$query = 'SELECT b.id AS id FROM ttg.bid b INNER JOIN ttg.period p ON p.id = b.period_id INNER JOIN ttg.exercise_user eu ON eu.id = b.exercise_user_id WHERE eu.uuid = $1 AND p.status = $2 LIMIT 1;';
	$arr = array($user_uuid, 'CURRENT');
	$res = pg_query_params($conn, $query, $arr);
	if (!$res) {
		echo "An error occurred.\n";
		exit;
	}
	$row = pg_fetch_row($res);
	return $row[0];
}

function queryPeriods($conn, $period_status = NULL) {
	$query = 'SELECT p.id AS pid, p.name AS period_name, p.status AS period_status FROM ttg.period AS p';
	$arr = array();
	if (isset($period_status)) {
		$arr[] = $period_status;
		$query = $query . ' WHERE p.status = $1';
	}
	$query = $query . ' ORDER BY p.id ASC';
	
	return pg_query_params($conn, $query, $arr);
}

function queryUsers($conn, $user_uuid = NULL, $login = NULL) {
	$query = 'SELECT u.id AS uid, u.uuid AS user_uuid, u.name AS user_name, u.login AS user_login FROM ttg.exercise_user u';
	$arr = array();
	if (isset($user_uuid)) {
		$arr[] = $user_uuid;
		$query = $query . ' WHERE u.uuid = $1';
	}
	elseif (isset($login)) {
		$arr[] = $login;
		$query = $query . ' WHERE u.login = $1';
	}
	$query = $query . ' ORDER BY u.id ASC';
	
	return pg_query_params($conn, $query, $arr);
}

function queryExerciseTypes($conn) {
	$query = 'SELECT t.id AS tid, t.value AS type FROM ttg.exercise_type t ORDER BY t.id ASC';
	$arr = array();
	
	return pg_query_params($conn, $query, $arr);
}

function queryUserStatistics($conn, $period_status = NULL) {
	
	$query = 	'SELECT u.name AS user_name, p.name AS period_name, p.status AS period_status, b.number AS bid, '.
				'(SELECT COUNT(*) FROM ttg.exercise e WHERE e.bid_id = b.id GROUP BY e.bid_id) AS total '.
				'FROM ttg.exercise_user u '.
				'INNER JOIN ttg.bid b ON u.id = b.exercise_user_id '. 
				'INNER JOIN ttg.period p ON p.id = b.period_id';

	$arr = array();
	if (isset($period_status))	{
		$query = $query . ' WHERE p.status = $1';
		$arr[] = $period_status;
	}
	
	$query = $query . ' ORDER BY total DESC';
		
	return pg_query_params($conn, $query, $arr);
}


?>