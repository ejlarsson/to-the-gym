<?php
session_start(); //gets session id from cookies, or prepa
if (session_id() == '' || !isset($_SESSION['user_uuid'])) { //if sid exists and login for sid exists
	$user_uuid == NULL;
} else {
  	$user_name = $_SESSION['user_name'];
	$user_uuid = $_SESSION['user_uuid'];
}
?>