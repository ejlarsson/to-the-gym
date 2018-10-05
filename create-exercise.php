<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {

	if(isset($_POST['date'])) {
		$date = $_POST['date'];
		if(isset($_POST['duration']) && $_POST['duration'] != '') $duration = $_POST['duration']; else $duration = NULL;
		if(isset($_POST['exercise_type']) && $_POST['exercise_type'] != '') $type = $_POST['exercise_type']; else $type = NULL;
		$user_uuid = $_SESSION['user_uuid'];
		
		include_once 'sql.php';
		
		echo $date . " | " . (isset($duration)) . " | " . ($type != '') . " | " . $user_uuid;
		
		if(createExercise(getConnection(), $user_uuid, $date, $duration, $type)) {
			header('Location: /exercises.php#show_exercises');
			echo "<noscript>Trening er registrert</noscript>";
		} else {
			header('Location: /');
			echo "<script>alert('Could not create exercise');</script>";
			echo "<noscript>Could not create exercise</noscript>";
		}
	}
}
	
?>