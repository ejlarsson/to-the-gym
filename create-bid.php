<?php
session_start(); //gets session id from cookies, or prepa

if (session_id() == '' || !empty($_SESSION['user_uuid'])) {
	header('Location: /'); //redirect to main
} else {
		echo 'asdf';
	if(!empty($_POST['bid'])) {
		$bid = $_POST['bid'];
		$user_uuid = $_SESSION['user_uuid'];
		
		include_once 'sql.php';
		$res = createBid(getConnection(), $user_uuid, $bid);		
		
		echo 'asdf';
		exit;
		if($res) {
			header('Location: /bids.php');
		} else {
			exit;
			header('Location: /');
		}
	}
}
	
?>