<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {

	if(isset($_POST['exercise_date'])) {
		$date = $_POST['exercise_date'];
		if(isset($_POST['duration'])) $duration = $_POST['duration']; else $duration = NULL;
		if(isset($_POST['exercise_type'])) $type = $_POST['exercise_type']; else $type = NULL;
		$user_uuid = $_SESSION['user_uuid'];
		
		include_once 'sql.php';
		
		echo $date . " | " . $duration . " | " . $type . " | " . $user_uuid;
		
		if(createExercise(getConnection(), $user_uuid, $date, $duration, $type)) {
			echo "<noscript>Trening er registrert</noscript>";
		} else {
			echo "<script>alert('Could not create exercise');</script>";
			echo "<noscript>Could not create exercise</noscript>";
		}
	}
}
	
?>

<form method="post">	
	<br>Treningstid:<input type="number" name="duration" min="30" max="1440">
	<br>Dato:<input type="date" name="date" id="exercise_date">
	<br>Type:<select name="exercise_type"><option selected /><option value="1">Løpning</option>
	<br><input type="submit">
</form>

<script>
document.getElementById('exercise_date').value = new Date().toDateInputValue();
</script>