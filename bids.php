<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	
	include_once 'sql.php';
	
	$user_uuid = $_SESSION['user_uuid'];
	
	$res = queryBids(getConnection(), $user_uuid, NULL);

?>

   <table>
     <tr>
       <td>Periode</td>
       <td>Bid</td>
       <td>Antall</td>
     </tr>
     <? while ($row = pg_fetch_assoc($res)) { ?>
     <tr>
       <td><? echo $row['period']; ?></td>
       <td><? if (!isset($row['bid'])) { echo '<a href="/create-bid.php?period='.$row['period'].'">Add</a>'; } else { echo $row['bid']; } ?></td>
       <td><? if (!isset($row['total'])) { echo '<a href="/create-exercise.php?period='.$row['period'].'">0</a>'; } else { echo '<a href="/exercises.php?&period='.$row['period'].'">'.$row['total'].'</a>'; } ?></td>
     </tr>
     <? } ?>
   </table>

<?php	

}

?>