<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['alarm_id']) && isset($_POST['friend_id']))
{
	// receiving the post params
	$alarm_id = $_POST['alarm_id'];
	$friend_id = $_POST['friend_id'];
	
	$db->addFriend($alarm_id, $friend_id);
}
?>