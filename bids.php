<?php

if (isset($_POST['login']) && isset($_SESSION['user_uuid'])) {
	
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
       <td><? echo $row['bid']; ?></td>
       <td><? echo $row['total']; ?></td>
     </tr>
     <? } ?>
   </table>

<?php	

} else {
	header('Location: /'); //redirect to main
}

?>