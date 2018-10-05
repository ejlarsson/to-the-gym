<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !isset($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
	if(!empty($_POST['bid'])) {
		$bid = $_POST['bid'];
		$user_uuid = $_SESSION['user_uuid'];
		
		include_once 'sql.php';
	
		if(createBid(getConnection(), $user_uuid, $bid)) {
			header('Location: /bids.php');
		} else {
			exit;
			header('Location: /');
		}
	}
}
	
?>