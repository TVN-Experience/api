<?php
require_once 'include/DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_GET['alarm_id']))
{
	// receiving the post params
	$alarm_id = $_GET['alarm_id'];
	
	$db->triggerEvent($alarm_id);
}
?>