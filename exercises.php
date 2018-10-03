<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	include_once 'sql.php';
	
	/* Expected link parameters: period, exercise, user */
	
	if(isset($_GET['period'])) $period = $_GET['period']; else $period = NULL;
	if(isset($_GET['user'])) $user_uuid = $_GET['user']; else $user_uuid = NULL;
	if(isset($_GET['exercise'])) $exercise_uuid = $_GET['exercise']; else $exercise_uuid = NULL;
	
	echo $user_uuid . " | " . $period . " | " . $exercise_uuid . "<br>";
	
	$res = queryExercises(getConnection(), $user_uuid, $period, $exercise_uuid);
	
	if (!$res) {
		echo "An error occurred.\n";
		exit;
	}
?>

   <table>
     <tr>
       <td>Hvem</td>
	   <td>UUID</td>
       <td>Periode</td>
       <td>Type</td>
	   <td>Lengd</td>
	   <td>Dato</td>
     </tr>
     <? while ($row = pg_fetch_assoc($res)) { ?>
     <tr>
       <td><? echo $row['user_name']; ?></td>
	   <td><? echo $row['user_uuid']; ?></td>
	   <td><? echo $row['period']; ?></td>
	   <td><? echo $row['exercise_type']; ?></td>
	   <td><? echo $row['exercise_duration']; ?></td>
	   <td><? echo $row['exercise_date']; ?></td>
    </tr>
     <? } ?>
   </table>

<?php	

}

?>