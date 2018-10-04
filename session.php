<?php
session_start();
if (session_id() == '' || !isset($_SESSION['user_uuid'])) { 
	$user_uuid == NULL;
} else {
  	$user_name = $_SESSION['user_name'];
	$user_uuid = $_SESSION['user_uuid'];
}
?>